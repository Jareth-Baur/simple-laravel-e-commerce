<x-app-layout>

    <!-- Christmas themed header -->
    <div class="d-flex justify-content-between align-items-center w-100 p-3">
        <!-- Logo -->
        <div class="d-flex align-items-center">
            <a href="{{ route('dashboard') }}" class="d-flex align-items-center">
                <i class="fas fa-gift mr-2"></i> <!-- Gift Icon -->
            </a>
        </div>

        <!-- Search Bar -->
        <div class="search-bar-container mx-auto" style="max-width: 600px;">
            <input type="text" id="product-search" class="form-control form-control-lg rounded-pill"
                placeholder="Search for Products" aria-label="Search">
        </div>


    </div>


    <!-- Main Content Area -->
    <div class="py-5">
        <div class="container">
            <div class="row">
                <!-- Filters Sidebar -->
                <div class="col-md-3 mb-4">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <h5 class="card-title">Filters & Sort</h5>

                            <!-- Category Filter -->
                            <div class="mb-3">
                                <label for="category-filter" class="form-label">Category:</label>
                                <select id="category-filter" class="form-select form-select-lg">
                                    <option value="All Category">All Category</option>
                                    <option value="Starter Kits">Starter Kits</option>
                                    <option value="dvanced Kits">Advanced Kits</option>
                                    <option value="E-Liquids">E-Liquids</option>
                                    <option value="Pod Systems">Pod Systems</option>
                                    <option value="Accessories">Accessories</option>
                                </select>
                            </div>

                            <!-- Sorting Filter -->
                            <div class="mb-3">
                                <label for="sort-products" class="form-label">Sort by:</label>
                                <select id="sort-products" class="form-select form-select-lg">
                                    <option value="a-z">A-Z</option>
                                    <option value="z-a">Z-A</option>
                                    <option value="low-high">Lowest to Highest Price</option>
                                    <option value="high-low">Highest to Lowest Price</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Listing -->
                <div class="col-md-9">
                    <h3 class="mb-4 text-center text-primary">Available Products</h3>
                    <div class="row g-4" id="product-list">
                        @foreach($products as $product)
                            @if($product->quantity > 0)
                                <div class="col-sm-6 col-md-4 product-item" data-name="{{ $product->name }}"
                                    data-category="{{ $product->category }}">
                                    <div class="card h-100 shadow-sm border-0 rounded-3">
                                        <div class="card-img-top position-relative">
                                            <img src="{{ asset('images/products/' . $product->image) }}"
                                                class="img-fluid rounded-top" alt="{{ $product->name }}">
                                            <!-- Favorite Icon Overlay -->
                                            <button type="button"
                                                class="btn btn-link position-absolute top-0 end-0 mt-2 me-2 text-danger p-0 favorite-icon"
                                                data-product-id="{{ $product->id }}">
                                                <i class="fas fa-heart fa-lg"></i>
                                            </button>
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title text-center text-dark">{{ $product->name }}</h5>
                                            <p class="text-muted text-center mb-1">Category: {{ $product->category }}</p>
                                            <p class="text-muted small text-center">{{ Str::limit($product->description, 70) }}
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <span class="badge bg-success">₱{{ number_format($product->price, 2) }}</span>
                                                <span class="badge bg-secondary">Stock: {{ $product->quantity }}</span>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-0 mt-auto">
                                            <div class="d-flex justify-content-between">
                                                <button class="btn btn-outline-primary btn-sm w-50 me-2 add-to-cart-text"
                                                    data-product-id="{{ $product->id }}">
                                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                                </button>
                                                <button class="btn btn-outline-success btn-sm w-50 buy-now-text"
                                                    data-product-id="{{ $product->id }}">
                                                    <i class="fas fa-credit-card"></i> Buy Now
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    @if($products->isEmpty())
                        <p class="text-center text-muted mt-4">No products available at the moment.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <!-- Snow effect for Christmas theme -->
    <style>
        body {
            background: url('https://cdn.pixabay.com/photo/2017/11/22/15/13/snow-2961323_960_720.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        /* Snowflake animation */
        .snowflake {
            position: absolute;
            top: -10%;
            z-index: 9999;
            pointer-events: none;
            color: white;
            font-size: 1em;
            animation: snow 10s linear infinite;
        }

        @keyframes snow {
            0% {
                transform: translateX(0) translateY(0);
            }

            100% {
                transform: translateX(100px) translateY(100vh);
            }
        }
    </style>

    <script>
        // // Snow Effect JavaScript
        // function generateSnowflakes() {
        //     let snowflakeContainer = document.body;

        //     for (let i = 0; i < 100; i++) {
        //         let snowflake = document.createElement("div");
        //         snowflake.classList.add("snowflake");
        //         snowflake.innerHTML = "❄️";
        //         snowflake.style.fontSize = `${Math.random() * 10 + 10}px`;
        //         snowflake.style.left = `${Math.random() * 100}%`;
        //         snowflake.style.animationDuration = `${Math.random() * 3 + 5}s`;
        //         snowflake.style.animationDelay = `${Math.random() * 5}s`;
        //         snowflakeContainer.appendChild(snowflake);
        //     }
        // }

        // generateSnowflakes();
    </script>

</x-app-layout>

<!-- Bootstrap, jQuery, and Font Awesome Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function () {
        // Product search functionality
        $('#product-search').on('input', function () {
            var searchText = $(this).val().toLowerCase();
            $('.product-item').each(function () {
                var productName = $(this).data('name').toLowerCase();
                if (productName.includes(searchText)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Category filter functionality
        $('#category-filter').on('change', function () {
            var selectedCategory = $(this).val();
            $('.product-item').each(function () {
                var productCategory = $(this).data('category');
                if (selectedCategory === 'All Category' || productCategory === selectedCategory) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Sorting functionality
        $('#sort-products').on('change', function () {
            var sortOrder = $(this).val();
            var productList = $('#product-list');
            var products = productList.children('.product-item').get();
            products.sort(function (a, b) {
                var nameA = $(a).data('name').toUpperCase();
                var nameB = $(b).data('name').toUpperCase();
                var priceA = parseFloat($(a).find('.font-weight-bold').text().replace('₱', '').replace(',', ''));
                var priceB = parseFloat($(b).find('.font-weight-bold').text().replace('₱', '').replace(',', ''));
                if (sortOrder === 'a-z') {
                    return nameA < nameB ? -1 : 1;
                } else if (sortOrder === 'z-a') {
                    return nameA > nameB ? -1 : 1;
                } else if (sortOrder === 'low-high') {
                    return priceA - priceB;
                } else if (sortOrder === 'high-low') {
                    return priceB - priceA;
                }
            });
            $.each(products, function (index, item) {
                productList.append(item);
            });
        });

        // Handle Add to Cart click event
        $(document).on('click', '.add-to-cart-text', function () {
            var productId = $(this).data('product-id');
            $.ajax({
                url: "{{ route('cart.add', '') }}/" + productId,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function (response) {
                    $('#cart-count').text(response.cart_count);
                    var currentStock = $('#product-stock-' + productId).text();
                    $('#product-stock-' + productId).text(currentStock - 1);
                    alert("Product added to cart!");
                },
                error: function (xhr) {
                    alert(xhr.responseJSON.error || "Error adding product to cart.");
                }
            });
        });

        // Handle Buy Now click event
        $(document).on('click', '.buy-now-text', function () {
            var productId = $(this).data('product-id');
            window.location.href = "{{ route('cart.view') }}";
        });

        // Favorite icon toggle functionality
        $(document).on('click', '.favorite-icon', function () {
            var icon = $(this).find('i');
            var productId = $(this).data('product-id');
            icon.toggleClass('text-danger'); // Change color on toggle

            // AJAX to add/remove from favorites
            $.ajax({
                url: "{{ route('favorite.toggle') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: productId
                },
                success: function (response) {
                    alert(response.message);
                }
            });
        });

    });
</script>