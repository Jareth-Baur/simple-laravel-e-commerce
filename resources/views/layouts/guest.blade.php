<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Additional Custom Styles */
        body {
            animation: fadeIn 0.5s ease-in-out;
            background: url('{{ asset('img/bg.jpg') }}') no-repeat center center fixed; /* Background image */
            background-size: cover;
            color: white; /* Change text color to white */
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Card Style */
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: rgba(0, 0, 0, 0.7); /* Darker transparent background for card */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            color: white; /* Ensure text inside card is white */
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Logo Hover Effect */
        .logo {
            transition: transform 0.3s ease;
        }
        .logo:hover {
            transform: scale(1.1); /* Grow effect */
        }

        .cart-icon, .user-icon {
        color: rgb(12, 15, 223) !important; /* Change icons to black */
        transition: color 0.3s ease;
        }

        .cart-icon:hover, .user-icon:hover {
            color: #555; /* Dark grey hover effect */
        }

    </style>
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="flex justify-center items-center mb-4">
            <a href="/">
                <img src="{{ asset('img/transpalogo.png') }}" alt="Logo" class="w-20 h-20 logo" />
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 card">
            <div class="text-gray-800">
                {{ $slot }}
            </div>
        </div>
    </div>

    <!-- Navigation Bar (Assumed) -->
    <div class="navbar">
        <!-- Cart Icon -->
        <a href="/cart" class="cart-icon">
            <i class="fas fa-shopping-cart"></i> <!-- Font Awesome Cart Icon -->
        </a>

        <!-- User Icon -->
        <a href="/user" class="user-icon">
            <i class="fas fa-user"></i> <!-- Font Awesome User Icon -->
        </a>
    </div>

</body>

</html>
