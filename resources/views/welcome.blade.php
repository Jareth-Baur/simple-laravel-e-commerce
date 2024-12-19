<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vape Shop</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap');

        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg,rgb(5, 5, 5),rgb(126, 120, 120));
            /* Soft gray gradient background */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .box {
            background: linear-gradient(135deg,rgb(214, 200, 200),rgb(126, 120, 120));
            /* Slightly opaque white box */
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
            position: relative;
            z-index: 1;
            transition: transform 0.3s ease;
        }

        .box:hover {
            transform: translateY(-3px);
            /* Lift effect on hover */
        }

        .box h1 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #333;
            /* Darker gray for title */
        }

        .box h2 {
            font-size: 1.25rem;
            font-weight: 500;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            color: #555;
            /* Slightly lighter gray for subtitle */
        }

        .box a {
            display: inline-block;
            margin-top: 0.5rem;
            padding: 0.5rem 1rem;
            background-color: #6c757d;
            /* Muted gray button */
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .box a:hover {
            background-color: #5a6268;
            /* Darker gray on hover */
            transform: translateY(-5px);
            /* Lift effect on hover */
        }

        .box .ml-4 {
            margin-left: 1rem;
        }

        /* Logo styling */
        .logo {
            display: block;
            margin-bottom: 1.5rem;
            width: 100px;
            height: auto;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.1);
            /* Slight grow effect on hover */
        }
    </style>
</head>

<body class="antialiased">
    <div class="container">
        <!-- Logo centered above the box -->
        <!-- <a href="/">
            <img src="{{ asset('img/transpalogo.png') }}" alt="Logo" class="logo" />
        </a> -->

        <!-- Box with User and Admin Login/Register -->
        <div class="box">
            <h1>Simple E-Commerce Vape Shop</h1>

            <!-- User Section -->
            <h2>User</h2>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-white">User Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-white">User Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-white">User Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</body>

</html>