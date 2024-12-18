<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap');
            
            body {
                font-family: 'Nunito', sans-serif;
                background: url('{{ asset('img/bg.jpg') }}') no-repeat center center fixed;
                background-size: cover;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                /* animation: fadeIn 0.5s ease-in-out; */
                overflow: hidden;
            }

            /* Apply a full, strong blur to the background
            body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(2px);
            z-index: -1;
        } */

            .container {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .box {
                background-color: rgba(255, 255, 255, 0.8);
                /* background-color: rgba(255, 255, 255, 0.2); Transparent box */
                padding: 2rem;
                border-radius: 10px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                text-align: center;
                max-width: 400px;
                width: 100%;
                position: relative;
                z-index: 1;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5); /* Black shadow */
                transition: transform 0.3s ease; /* Transition for hover effect */
            }

            .box:hover {
                transform: translateY(-3px); /* Lift the box slightly on hover */
            }

            .box h1 {
                font-size: 1.5rem;
                font-weight: 600;
                margin-bottom: 1rem;
                color: black;
            }

            .box h2 {
                font-size: 1.25rem;
                font-weight: 500;
                margin-top: 1.5rem;
                margin-bottom: 1rem;
                color: black;
            }

            .box a {
                display: inline-block;
                margin-top: 0.5rem;
                padding: 0.5rem 1rem;
                background-color: #4a5568;
                color: #fff;
                border-radius: 5px;
                text-decoration: none;
                transition: background-color 0.3s ease;
                
            }

            .box a:hover {
                background-color: #2d3748;
                transform: translateY(-5px); /* Lift the box slightly on hover */
            }

            .box .ml-4 {
                margin-left: 1rem;
            }

            /* Fade-in animation */
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }

            /* Logo styling */
            .logo {
                display: block;
                margin-bottom: 1.5rem;
                width: 100px; /* Smaller size */
                height: auto;
                transition: transform 0.3s ease;
            }

            .logo:hover {
                transform: scale(1.1); /* Grow effect */
                /* animation: spin 0.5s linear infinite; */
            }

            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="container">
            <!-- Logo centered above the box -->
            <a href="/">
                <img src="{{ asset('img/transpalogo.png') }}" alt="Logo" class="logo" />
            </a>

            <!-- Box with User and Admin Login/Register -->
            <div class="box">
                <h1>Welcome to Fitness Shop!</h1>

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