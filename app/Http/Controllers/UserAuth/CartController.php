<?php

namespace App\Http\Controllers\UserAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request, $id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($id);

        // Check if there is enough stock available
        if ($product->quantity <= 0) {
            return response()->json([
                'error' => 'This product is out of stock.'
            ], 400); // Return error if out of stock
        }

        // Find or create a cart for the user
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        // Check if the product already exists in the cart
        $cartItem = $cart->items()->where('product_id', $id)->first();

        if ($cartItem) {
            // If the item exists, increase its quantity
            $cartItem->increment('quantity');
        } else {
            // Otherwise, add the new item to the cart
            $cartItem = $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        // Deduct the quantity from the product stock
        $product->decrement('quantity');

        // Calculate the new cart item count
        $cartCount = $cart->items()->sum('quantity');

        // Return JSON response with the updated cart count
        return response()->json([
            'cart_count' => $cartCount,
            'message' => 'Product added to cart successfully!'
        ]);
    }

    public function viewCart()
    {
        $cart = Cart::where('user_id', Auth::id())->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            // If no cart or items, return an empty cart view
            return view('user.cart', ['cart' => null, 'message' => 'Your cart is empty.']);
        }

        return view('user.cart', compact('cart'));
    }

    public function removeFromCart(Request $request, $id)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        // Find the cart item by ID
        $cartItem = $cart->items()->where('id', $id)->first();

        if ($cartItem) {
            // Restore product quantity to stock before removing from cart
            $product = $cartItem->product; // Assuming CartItem has a relationship to Product
            $product->increment('quantity', $cartItem->quantity); // Restore the stock

            // Remove the item from the cart
            $cartItem->delete();

            return redirect()->back()->with('success', 'Item removed from cart successfully!');
        }

        return redirect()->back()->with('error', 'Item not found in cart.');
    }
    public function updateQuantity(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1',
        ]);
    
        $cartItem = CartItem::findOrFail($request->cart_item_id);
        $product = $cartItem->product;
    
        $newQuantity = $request->quantity;
        $currentCartQuantity = $cartItem->quantity;
        $difference = $newQuantity - $currentCartQuantity;
    
        // Check if the new quantity exceeds available stock
        if ($difference > $product->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'The requested quantity exceeds available stock.',
            ], 400);
        }
    
        // Update product stock
        $product->quantity -= $difference;
        $product->save();
    
        // Update cart item quantity
        $cartItem->quantity = $newQuantity;
        $cartItem->save();
    
        return response()->json([
            'success' => true,
            'item_total' => number_format($product->price * $cartItem->quantity, 2),
            'cart_total' => number_format(auth()->user()->cart->items->sum(fn($item) => $item->product->price * $item->quantity), 2),
        ]);
    }



    
    
    
    
  
































    

    public function editCartItem($id)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart) {
            return redirect()->route('cart.view')->with('error', 'No cart found.');
        }

        // Find the cart item to be edited
        $cartItem = $cart->items()->where('id', $id)->first();

        if (!$cartItem) {
            return redirect()->route('cart.view')->with('error', 'Cart item not found.');
        }

        // Return the edit view with the cart item details
        return view('user.edit', compact('cartItem'));
    }
}
