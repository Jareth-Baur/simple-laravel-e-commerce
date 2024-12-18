<x-app-layout>
    <div class="container mt-5">
        <!-- Page Title -->
        <h2 class="text-center mb-4 text-primary">Order Confirmation</h2>

        <!-- Display Selected Items -->
        <div class="order-details mb-4">
            <h3 class="mb-3 text-secondary">Your Selected Items</h3>
            <ul class="list-group">
                @foreach ($selectedCartItems as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h5>{{ $item->product->name }}</h5>
                            <p class="mb-1">Quantity: {{ $item->quantity }}</p>
                            <p>Price: ₱{{ number_format($item->product->price, 2) }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Total Price -->
        <div class="order-summary text-end mb-4">
            <h4 class="font-weight-bold text-success">Total Price: ₱{{ number_format($total, 2) }}</h4>
        </div>

        <!-- Payment Method Form -->
        <div class="payment-method mt-4 p-4 border rounded shadow-sm">
            <h3 class="mb-3 text-primary">Payment Information</h3>
            <form action="{{ route('order.confirm') }}" method="POST">
                @csrf
                <!-- Payment Method Select -->
                <div class="mb-4">
                    <label for="payment_method" class="form-label">Choose Payment Method:</label>
                    <select name="payment_method" id="payment_method" class="form-select" required onchange="showPaymentFields()">
                        <option value="credit_card">Credit Card</option>
                        <option value="paypal">PayPal</option>
                        <option value="gcash">GCash</option>
                        <option value="cod">Cash on Delivery</option>
                    </select>
                </div>

                <!-- Dynamic Payment Fields -->
                <div id="credit_card_fields" class="payment-fields mb-3" style="display: none;">
                    <label for="card_number" class="form-label">Card Number:</label>
                    <input type="text" name="card_number" id="card_number" class="form-control" placeholder="Enter your card number">

                    <label for="expiration_date" class="form-label mt-2">Expiration Date:</label>
                    <input type="text" name="expiration_date" id="expiration_date" class="form-control" placeholder="MM/YY">

                    <label for="card_owner_name" class="form-label mt-2">Card Owner Name:</label>
                    <input type="text" name="card_owner_name" id="card_owner_name" class="form-control" placeholder="Enter card owner's name">

                    <label for="cvv" class="form-label mt-2">CVV:</label>
                    <input type="text" name="cvv" id="cvv" class="form-control" placeholder="Enter CVV" maxlength="3">
                </div>

                <div id="paypal_fields" class="payment-fields mb-3" style="display: none;">
                    <label for="paypal_email" class="form-label">PayPal Email:</label>
                    <input type="email" name="paypal_email" id="paypal_email" class="form-control" placeholder="Enter your PayPal email">

                    <label for="paypal_preference_code" class="form-label mt-2">PayPal Preference Code:</label>
                    <input type="text" name="paypal_preference_code" id="paypal_preference_code" class="form-control" placeholder="Enter your PayPal preference code">
                </div>

                <div id="gcash_fields" class="payment-fields mb-3" style="display: none;">
                    <label for="gcash_number" class="form-label">GCash Number:</label>
                    <input type="text" name="gcash_number" id="gcash_number" class="form-control" placeholder="Enter your GCash number">

                    <label for="gcash_preference_code" class="form-label mt-2">GCash Preference Code:</label>
                    <input type="text" name="gcash_preference_code" id="gcash_preference_code" class="form-control" placeholder="Enter your GCash preference code">
                </div>

                <div id="cod_details" class="payment-fields mb-3" style="display: none;">
                    <label for="cod_address" class="form-label">Delivery Address:</label>
                    <input type="text" name="cod_address" id="cod_address" class="form-control" placeholder="Enter your delivery address for COD">
                </div>

                <!-- Action Buttons -->
                <div class="text-end mt-4">
                    <a href="{{ route('user.dashboard') }}" class="btn btn-secondary btn-lg me-2">Cancel</a>
                    <button type="submit" class="btn btn-lg btn-primary">Confirm Order</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showPaymentFields() {
            const paymentMethod = document.getElementById('payment_method').value;

            // Hide all payment fields first
            const paymentFields = document.querySelectorAll('.payment-fields');
            paymentFields.forEach(field => field.style.display = 'none');

            // Show relevant payment fields based on selected payment method
            if (paymentMethod === 'credit_card') {
                document.getElementById('credit_card_fields').style.display = 'block';
                document.getElementById('payment_details_div').style.display = 'block';
            } else if (paymentMethod === 'paypal') {
                document.getElementById('paypal_fields').style.display = 'block';
                document.getElementById('payment_details_div').style.display = 'block';
            } else if (paymentMethod === 'gcash') {
                document.getElementById('gcash_fields').style.display = 'block';
            } else if (paymentMethod === 'cod') {
                document.getElementById('cod_details').style.display = 'block';
            }
        }

        // Trigger payment fields on page load based on default selected value
        document.addEventListener('DOMContentLoaded', function() {
            showPaymentFields();
        });
    </script>
</x-app-layout>
