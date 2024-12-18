<!-- resources/views/payment/index.blade.php -->
<x-app-layout>
    <div class="container py-6">
        <h2 class="text-center display-4 mb-5">Proceed to Payment</h2>

        <form action="{{ route('payment.process') }}" method="POST">
            @csrf
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4>Order Summary</h4>
                    <ul class="list-group mb-4">
                        @foreach($order->items as $item)
                            <li class="list-group-item">
                                <p><strong>{{ $item->product->name }}</strong></p>
                                <p>Quantity: {{ $item->quantity }}</p>
                                <p>Price: ₱{{ number_format($item->price, 2) }}</p>
                            </li>
                        @endforeach
                    </ul>

                    <p><strong>Total Amount:</strong> ₱{{ number_format($order->total, 2) }}</p>

                    <!-- Payment details section -->
                    <div class="form-group">
                        <label for="payment_method">Payment Method</label>
                        <select class="form-control" id="payment_method" name="payment_method" required>
                            <option value="credit_card">Credit Card</option>
                            <option value="paypal">PayPal</option>
                            <!-- Add other payment options here -->
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('cart.index') }}" class="btn btn-danger">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-success">
                            Pay Now
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
