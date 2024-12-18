<x-app-layout>
    <div class="py-12">
        <div class="container">
            <div class="text-center mb-5">
                <!-- Centered Heading -->
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Your Favorite Products') }}
                </h2>
            </div>

            @if($favorites->isEmpty())
                <div class="alert alert-info text-center">
                    You don't have any favorite products yet.
                </div>
            @else
                <div class="bg-white shadow-sm rounded mx-auto" style="max-width: 1200px;">
                    <div class="p-6">
                        <h3 class="mb-4 text-center">Your Favorite Products</h3>

                        @csrf
                        <div class="row justify-content-center">
                            @foreach($favorites as $favorite)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-body d-flex flex-column">
                                            <!-- Product Title and Favorite Icon -->
                                            <h5 class="card-title mb-0">{{ $favorite->product->name }}</h5>
                                            <p class="card-text">Description: {{ $favorite->product->description }}</p>
                                            <p class="text-success font-weight-bold">₱{{ number_format($favorite->product->price, 2) }}</p>

                                            <!-- Product Checkbox for Checkout -->
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <div class="form-check">
                                                    <label class="form-check-label" for="product-{{ $favorite->product->id }}">
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Remove Favorite Button (No color and icon) -->
                                            <button type="button" class="remove-favorite-button mt-3" data-product-id="{{ $favorite->product->id }}">
                                                Remove from Favorites
                                            </button>

                                            <!-- Add to Cart Button (No color and icon) -->
                                            <button type="button" class="add-to-cart-button mt-3" data-product-id="{{ $favorite->product->id }}">
                                                Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

<!-- Scripts for handling the removal of a favorite and adding to cart -->
<script>
    $(document).ready(function() {
        // Handle remove from favorites
        $(document).on('click', '.remove-favorite-button', function() {
            var productId = $(this).data('product-id');

            $.ajax({
                url: "{{ route('favorite.toggle') }}", // Route for toggling favorite
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: productId
                },
                success: function(response) {
                    alert(response.message); // Show success message
                    location.reload(); // Reload the page to reflect the changes
                },
                error: function(xhr) {
                    alert("Error removing favorite.");
                }
            });
        });

        // Handle add to cart
        $(document).on('click', '.add-to-cart-button', function() {
            var productId = $(this).data('product-id');

            // Add product to cart
            $.ajax({
                url: "{{ route('cart.add', ':id') }}".replace(':id', productId), // Route for adding to cart
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: productId
                },
                success: function(response) {
                    alert(response.message); // Show success message

                    // Remove product from favorites after adding to cart
                    $.ajax({
                        url: "{{ route('favorite.remove') }}", // Route to remove from favorites
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            product_id: productId
                        },
                        success: function(removeResponse) {
                            alert(removeResponse.message); // Show success message for removal
                            location.reload(); // Reload the page to reflect the changes
                        },
                        error: function(xhr) {
                            alert("Error removing product from favorites after adding to cart.");
                        }
                    });
                },
                error: function(xhr) {
                    alert("Error adding product to cart.");
                }
            });
        });
    });
</script>
