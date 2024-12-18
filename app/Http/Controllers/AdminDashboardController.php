<?php

namespace App\Http\Controllers;

use App\Models\Order; // Import the Order model
use App\Models\OrderItem; // Import the OrderItem model
use App\Models\Product; // Import the Product model
use App\Models\CartItem; // Import the CartItem model (to track cart additions)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard with the list of orders.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch all orders along with associated users
        $orders = Order::with('user')->get(); // Assuming 'user' relationship is defined on Order model
        $user = Auth::user();
        
        // Fetch the most sold product, most favorite product, and most added to cart product
        $mostSoldProduct = $this->getMostSoldProduct(); // Your existing logic
        $mostFavoriteProduct = $this->getMostFavoriteProduct(); // Your existing logic

        // Most added to cart product
        $mostAddedToCartProduct = Product::withCount('cart_items')
                                        ->orderByDesc('cart_items_count')
                                        ->first();

        // Count the quantity of each product sold
        $orderedProducts = OrderItem::select('product_id', DB::raw('sum(quantity) as total_quantity'))
                                    ->groupBy('product_id')
                                    ->orderByDesc('total_quantity')
                                    ->get()
                                    ->map(function($item) {
                                        $item->product_name = $item->product->name; // Assuming each OrderItem has a related Product
                                        return $item;
                                    });

        // Count the quantity of each product in cart
        $cartProducts = CartItem::select('product_id', DB::raw('count(*) as cart_count'))
                                ->groupBy('product_id')
                                ->orderByDesc('cart_count')
                                ->get()
                                ->map(function($item) {
                                    $item->product_name = $item->product->name; // Assuming each CartItem has a related Product
                                    return $item;
                                });

        // Pass the orders data and product counts to the dashboard view
        return view('admin.dashboard', compact('orders', 'mostSoldProduct', 'mostFavoriteProduct', 'mostAddedToCartProduct', 'orderedProducts', 'cartProducts'));
    }

    /**
     * Display all orders for admin view with product and user relationships.
     *
     * @return \Illuminate\View\View
     */
    public function viewOrders()
    {
        // Retrieve all orders along with associated user, order items (product, quantity, price), and payments
        $orders = Order::with(['user', 'items.product', 'payments'])->get(); // Correct eager loading for 'user', 'items.product', and 'payments'
        
        // Return the view with orders data
        return view('admin.dashboard', compact('orders'));
    }

    /**
     * Show the dashboard with products, orders, most sold and most favorite products.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // Retrieve products that have been favorited
        $favoriteProducts = Product::withCount('favoritedBy')  // Count the number of favorites for each product
            ->having('favorited_by_count', '>', 0)  // Include only products that have been favorited
            ->orderBy('favorited_by_count', 'desc')  // Order by the number of favorites (descending)
            ->get();
    
        // Retrieve products that have been ordered
        $orderedProducts = Product::withSum('orderItems', 'quantity')  // Get total quantity sold for each product
            ->having('order_items_sum_quantity', '>', 0)  // Include only products that have been ordered
            ->orderBy('order_items_sum_quantity', 'desc')  // Order by quantity sold (descending)
            ->get();
    
        // Find the most sold product by quantity
        $mostSoldProduct = $orderedProducts->sortByDesc('order_items_sum_quantity')->first();
    
        // Find the most favorite product by number of favorites
        $mostFavoriteProduct = $favoriteProducts->sortByDesc('favorited_by_count')->first();
    
        // Retrieve all orders with their items (if necessary, adjust the relationships)
        $orders = Order::with(['items.product', 'user', 'payments'])->get();
    
        // Retrieve the most added to cart product
        $mostAddedToCartProduct = Product::withCount('cartItems')
                                 ->orderByDesc('cart_items_count')
                                 ->first();

    
        // Return the view with the filtered products, most sold, most favorite products, and orders
        return view('admin.dashboard', compact('orderedProducts', 'favoriteProducts', 'mostSoldProduct', 'mostFavoriteProduct', 'mostAddedToCartProduct', 'orders'));
    }

    public function modaldashboard()
    {
        // Retrieve orders with their associated data
        $orders = Order::with(['user', 'items.product', 'payments'])->get();

        // Pass the orders data to the view
        return view('admin.allorders', compact('orders'));
    }
    
}
