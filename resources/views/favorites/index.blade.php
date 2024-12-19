<x-app-layout>
    <div class="py-12">
        <div class="container">
            <div class="text-center mb-5">
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

                        <div class="row row-cols-1 row-cols-md-3 g-4">
                            @foreach($favorites as $favorite)
                                <div class="col">
                                    <div class="card h-100 shadow-sm">
                                        <img src="{{ $favorite->product->image_url }}" class="card-img-top"
                                            alt="{{ $favorite->product->name }}" style="height: 200px; object-fit: cover;">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">{{ $favorite->product->name }}</h5>
                                            <p class="card-text">{{ Str::limit($favorite->product->description, 100) }}</p>
                                            <p class="text-success fw-bold">₱{{ number_format($favorite->product->price, 2) }}
                                            </p>

                                            <!-- Buttons -->
                                            <div class="mt-auto d-flex justify-content-between">
                                                <button type="button" class="btn btn-danger remove-favorite-button"
                                                    data-product-id="{{ $favorite->product->id }}">
                                                    <i class="fas fa-heart-broken"></i> Remove
                                                </button>
                                                <button type="button" class="btn btn-primary add-to-cart-button"
                                                    data-product-id="{{ $favorite->product->id }}">
                                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                                </button>
                                            </div>
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

<!-- Scripts for handling actions -->
<script>
    $(document).ready(function () {
        // Handle remove from favorites
        $(document).on('click', '.remove-favorite-button', function () {
            let productId = $(this).data('product-id');

            $.ajax({
                url: "{{ route('favorite.toggle') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: productId
                },
                success: function (response) {
                    alert(response.message);
                    location.reload();
                },
                error: function (xhr) {
                    alert("Error removing product from favorites.");
                }
            });
        });

        // Handle add to cart
        $(document).on('click', '.add-to-cart-button', function () {
            let productId = $(this).data('product-id');

            $.ajax({
                url: "{{ route('cart.add', ':id') }}".replace(':id', productId),
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: productId
                },
                success: function (response) {
                    alert(response.message);
                    location.reload();
                },
                error: function (xhr) {
                    alert("Error adding product to cart.");
                }
            });
        });
    });
</script>