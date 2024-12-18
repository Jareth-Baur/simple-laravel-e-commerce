<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <div class="container py-3">
            <!-- Logo and Navigation -->
            <div class="d-flex justify-content-between align-items-center">
                <!-- Logo -->
                <div class="logo">
                    <a href="#" class="text-decoration-none">
                        <img src="{{ asset('img/transpalogo.jpg') }}" alt="Logo" width="150">
                    </a>
                </div>
               
            </div>
        </div>
    </x-slot>
</x-app-layout>

<!-- Bootstrap and jQuery Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // Product search functionality
        $('#product-search').on('input', function() {
            var searchText = $(this).val().toLowerCase();
            // You can add a function here to filter products if there is a product list
        });
    });
</script>
