<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8;
            background-image: url('https://www.transparenttextures.com/patterns/snowflakes.png'); /* Christmas-themed background */
        }

        .sidebar {
            transition: transform 0.3s ease-in-out;
        }

        .sidebar-item:hover {
            background-color: rgba(255, 0, 0, 0.2); /* Light red hover effect */
        }

        .sidebar-item.active {
            background-color: rgba(34, 193, 195, 0.2); /* Active item green color */
        }

        .sidebar-header {
            font-family: 'Arial', sans-serif;
            font-size: 1.5rem;
            color: #fff;
            text-align: center;
        }

        .sidebar-item {
            color: #fff;
        }

        .sidebar-item i {
            color: #ffdf00; /* Gold icon color for the Christmas theme */
        }

        .sidebar-item:hover i {
            color: #fff; /* White icon color when hovered */
        }

        .bg-christmas {
            background-color: #d32f2f; /* Christmas Red */
        }

        .bg-green-christmas {
            background-color: #388e3c; /* Christmas Green */
        }

        .bg-gold-christmas {
            background-color: #ffdf00; /* Gold color for highlights */
        }

        .card-header {
            background-color: #388e3c; /* Green header */
            color: white;
        }

        .card-body {
            background-color: #f4f4f9;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans">

    <!-- Sidebar -->
    <div class="flex">
        <!-- Sidebar Navigation -->
        <aside class="sidebar fixed top-0 left-0 h-screen w-64 bg-gradient-to-b from-red-600 to-green-600 text-white shadow-lg">
            <div class="p-6">
                <h2 class="sidebar-header text-2xl font-semibold mb-8 text-red-200">Admin Menu</h2>
                <nav>
                    <ul class="space-y-6">
                        <li>
                            <a href="{{ route('admin.dashboard') }}"
                                class="sidebar-item block py-2 px-4 rounded-md text-white hover:bg-green-500 transition {{ request()->routeIs('admin.dashboard') ? 'bg-green-500' : '' }}">
                                <i class="fas fa-tachometer-alt sidebar-icon mr-3"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.products.index') }}"
                                class="sidebar-item block py-2 px-4 rounded-md text-white hover:bg-green-500 transition {{ request()->routeIs('admin.products.index') ? 'bg-green-500' : '' }}">
                                <i class="fas fa-cogs sidebar-icon mr-3"></i> Products
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.allorders') }}"
                                class="sidebar-item block py-2 px-4 rounded-md text-white hover:bg-green-500 transition {{ request()->routeIs('admin.allorders') ? 'bg-green-500' : '' }}">
                                <i class="fas fa-list-ul sidebar-icon mr-3"></i> View All Orders
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST" id="logout-form">
                                @csrf
                                <button type="button" onclick="document.getElementById('logout-form').submit();"
                                    class="sidebar-item block w-full text-left py-2 px-4 rounded-md text-white hover:bg-red-600 transition bg-red-500">
                                    <i class="fas fa-sign-out-alt sidebar-icon mr-3"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 ml-64 p-8">
            <!-- Header -->
            <header class="bg-white p-6 rounded-lg shadow-md mb-8 border border-gray-200 flex items-center justify-center">
                <h1 class="text-4xl font-bold text-red-600">@yield('title', 'Admin Dashboard')</h1>
            </header>

            <!-- Dashboard Content -->
            <main>
                @yield('content')
            </main>
        </div>
    </div>

</body>

</html>
