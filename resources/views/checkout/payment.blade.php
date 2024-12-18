<!-- resources/views/checkout/payment.blade.php -->
<x-app-layout>
    <div class="container py-5">
        <h2 class="text-center mb-4">Choose Payment Method</h2>

        <form action="{{ route('checkout.complete', ['order' => $order->id]) }}" method="POST">
            @csrf
            <div class="alert alert-info text-center">
                <p>Your order total: ₱{{ number_format($order->total, 2) }}</p>
            </div>

            <!-- Example of payment methods -->
            <div class="mb-3">
                <label for="payment_method" class="form-label">Select Payment Method</label>
                <select id="payment_method" name="payment_method" class="form-control">
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
            </div>

            <div class="text-center mt-5">
                <button type="submit" class="btn btn-success">Proceed to Payment</button>
            </div>
        </form>
    </div>
</x-app-layout>

