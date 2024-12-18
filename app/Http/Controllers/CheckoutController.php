<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\OrderItem;
use App\Models\PaymentDetail;
use Auth;

class CheckoutController extends Controller
{
    /**
     * Show the order confirmation page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function processCheckout(Request $request)
    {
        // Ensure the user is authenticated
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('message', 'You must be logged in to proceed!');
        }

        // Get selected item IDs (passed as JSON in the request)
        $selectedItems = json_decode($request->input('selected_items', '[]'), true);

        // Validate if the selected items are valid
        if (empty($selectedItems)) {
            return redirect()->route('dashboard')->with('message', 'No items selected for checkout!');
        }

        // Retrieve the user's cart
        $cart = $user->cart; // Assuming user has a relationship with Cart

        // Check if the cart exists and has items
        if (!$cart || !$cart->items->count()) {
            return redirect()->route('cart.index')->with('message', 'Your cart is empty!');
        }

        // Filter the selected items from the cart
        $selectedCartItems = $cart->items->whereIn('id', $selectedItems);

        // If there are no selected items in the cart, return an error
       

        // Step 1: Calculate the total order price
        $total = $selectedCartItems->sum(function ($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        });

        // Step 2: Store the selected items and total in the session for confirmation
        session([
            'selected_cart_items' => $selectedCartItems->pluck('id')->toArray(), // Store IDs of selected items
            'total' => $total
        ]);

        // Return the view with the selected items and total passed to the view
        return view('checkout.confirmation', [
            'selectedCartItems' => $selectedCartItems,
            'total' => $total
        ]);
    }

    /**
     * Confirm the order and save the payment method.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmOrder(Request $request)
    {
        // Ensure the user is authenticated
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('message', 'You must be logged in to place an order!');
        }

        // Validate payment method and details
        $validated = $request->validate([
            'payment_method' => 'required|string',
            'card_number' => 'nullable|string',
            'expiration_date' => 'nullable|string',
            'card_owner_name' => 'nullable|string',
            'cvv' => 'nullable|string|max:3',
            'paypal_email' => 'nullable|email',
            'paypal_preference_code' => 'nullable|string',
            'gcash_number' => 'nullable|string',
            'gcash_preference_code' => 'nullable|string',
            'cod_address' => 'nullable|string',
        ]);

        // Retrieve selected item IDs from session
        $selectedItemIds = session('selected_cart_items', []);

        if (empty($selectedItemIds)) {
            return redirect()->route('cart.index')->with('message', 'No items selected for checkout!');
        }

        // Get the user's cart
        $cart = $user->cart;

        if (!$cart) {
            return redirect()->route('cart.index')->with('message', 'Cart not found!');
        }

        // Filter selected items from the cart
        $selectedItems = $cart->items->filter(function ($item) use ($selectedItemIds) {
            return in_array($item->id, $selectedItemIds);
        });

        if ($selectedItems->isEmpty()) {
            return redirect()->route('cart.index')->with('message', 'Invalid items selected!');
        }

        // Step 3: Create order from selected items only
        $order = Order::create([
            'user_id' => $user->id,
            'total' => $selectedItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            }),
            'status' => 'pending', // Change this based on your workflow
        ]);

        // Step 4: Attach selected items to the order
        foreach ($selectedItems as $item) {
            $order->items()->create([
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        // Step 5: Store the payment details
        $paymentDetails = new Payment([
            'order_id' => $order->id,
            'payment_method' => $validated['payment_method'],
            'card_number' => $validated['card_number'],
            'expiration_date' => $validated['expiration_date'],
            'card_owner_name' => $validated['card_owner_name'],
            'cvv' => $validated['cvv'],
            'paypal_email' => $validated['paypal_email'],
            'paypal_preference_code' => $validated['paypal_preference_code'],
            'gcash_number' => $validated['gcash_number'],
            'gcash_preference_code' => $validated['gcash_preference_code'],
            'cod_address' => $validated['cod_address'],
        ]);

        $paymentDetails->save();

        // Step 6: Process the payment based on the selected payment method

        // Step 7: Remove selected items from the cart
        foreach ($selectedItems as $item) {
            $item->delete();
        }

        // Clear session data
        session()->forget(['selected_cart_items', 'total']);

        // Step 8: Redirect with success message
        return redirect()->route('order.confirmation', ['order' => $order])->with('success', 'Order placed successfully!');
    }

    /**
     * Handle payment processing logic based on selected payment method.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    private function processPaymentMethod(Request $request, Payment $payment)
    {
        switch ($request->input('payment_method')) {
            case 'credit_card':
                // Process credit card payment (you can integrate a payment gateway here)
                $payment->update(['status' => 'completed']);
                break;

            case 'paypal':
                // Process PayPal payment (you can integrate PayPal API here)
                $payment->update(['status' => 'completed']);
                break;

            case 'bank_transfer':
                // Process bank transfer payment
                $payment->update(['status' => 'completed']);
                break;

            case 'cash_on_delivery':
                // Handle cash on delivery
                $payment->update(['status' => 'pending']);
                break;

            case 'gcash':
                // Process GCash payment
                $payment->update(['status' => 'completed']);
                break;

            default:
                // If no valid payment method is selected, update the status to failed
                $payment->update(['status' => 'failed']);
                break;
        }
    }

    /**
     * Show the order confirmation details after payment.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function orderConfirmation(Order $order)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('home')->with('error', 'You are not authorized to view this order.');
        }

        // Flash a simple notification message to the session
        session()->flash('notification', 'Your order has been successfully processed!');

        // Return the order confirmation view
        return view('checkout.order_confirmation', [
            'order' => $order,
        ]);
    }

    /**
     * Show the list of orders for the authenticated user.
     *
     * @return \Illuminate\View\View
     */
    public function showOrders()
    {
        // Fetch the orders for the authenticated user, with pagination
        $orders = Auth::user()->orders()->paginate(10); // Adjust pagination as needed

        return view('checkout.order_list', compact('orders'));
    }
}
