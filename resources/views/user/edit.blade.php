<x-app-layout>
    <div class="container">
        <h2>Edit Cart Item</h2>

        <form id="updateCartForm">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $cartItem->quantity }}" min="1" required>
            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary">Update Quantity</button>
            </div>
        </form>

        <a href="{{ route('cart.view') }}" class="btn btn-secondary mt-3">Back to Cart</a>
    </div>

    <!-- Include jQuery if not already included in your layout -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // AJAX request to update the cart quantity
        $('#updateCartForm').on('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting the traditional way

            var quantity = $('#quantity').val();  // Get the quantity value from the input field
            var cartItemId = "{{ $cartItem->id }}";  // Get the cart item ID

            // Send an AJAX PUT request
            $.ajax({
                url: "{{ url('cart/update') }}/" + cartItemId,  // Use the full URL
                method: 'PUT',
                data: {
                    _token: $('input[name="_token"]').val(),
                    quantity: quantity  // Send the updated quantity
                },
                success: function(response) {
                    // Handle the success response
                    if (response.success) {
                        alert('Cart updated successfully!');
                        window.location.href = '{{ route('cart.view') }}';  // Redirect to the cart page
                    } else {
                        alert('Error updating cart');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle any errors
                    alert('Something went wrong, please try again!');
                }
            });
        });
    </script>

</x-app-layout>
