<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Auth;

class OrderController extends Controller
{
    // Display all orders for the authenticated user
    public function index()
    {
        $user = Auth::user(); // Get the authenticated user
        $orders = Order::where('user_id', $user->id)->get(); // Get orders associated with the user
        return view('orders.index', compact('orders'));
    }
    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status == 'pending') {
            // Ensure status is updated to a valid value
            $order->update(['status' => 'cancelled']);
            // Additional logic like sending a notification can be added here
            return redirect()->route('Order_List')->with('success', 'Order has been canceled.');
        } else {
            return redirect()->route('Order_List')->with('error', 'Order cannot be canceled.');
        }
    }

}
