<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap 5 (Latest stable version for UI components) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tailwind CSS (Utility-first framework for customizable design) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Custom Styles (Optional, if you have a custom.css file) -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" />
    
    <!-- Scripts (Optional, Tailwind + Bootstrap JS, Popper.js) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50">

    <!-- Main Content Area -->
    <div class="min-h-screen" id="content">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow-lg py-5">
                <div class="container">
                    <h1 class="text-3xl text-center font-semibold text-gray-800">{{ $header }}</h1>
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            <div class="container py-6">
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- Bootstrap 5 JS and Popper.js (Required for dropdowns, tooltips, modals, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Optional: Your custom scripts (if any) -->
    <script src="{{ asset('js/custom.js') }}"></script>

    <!-- JavaScript to Dynamically Set Background Image -->
    <script>
        // Set background image from the Laravel asset path dynamically
        document.addEventListener('DOMContentLoaded', function() {
            var backgroundImage = "{{ asset('img/fit.jpg') }}";  // Using the asset helper to get the correct URL
            document.body.style.backgroundImage = 'url(' + backgroundImage + ')';
            document.body.style.backgroundSize = 'cover';
            document.body.style.backgroundPosition = 'center center';
            document.body.style.backgroundAttachment = 'fixed';
            document.body.style.backgroundRepeat = 'no-repeat';
        });
    </script>

    <!-- Custom Style to Change Cart and User Icon Color to White -->
    <style>
        /* Change Cart and User Icon Color to White */
        .fa-shopping-cart,
        .fa-user-circle {
            color: white !important;
        }

        /* Optional: Change the icon color on hover */
        .fa-shopping-cart:hover,
        .fa-user-circle:hover {
            color: #f0f0f0 !important; /* Light color for hover effect */
        }
    </style>
</body>

</html>
