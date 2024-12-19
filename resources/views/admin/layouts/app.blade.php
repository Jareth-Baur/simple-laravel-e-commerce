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
            background-color: #f8f9fa;
            background-image: url('https://www.transparenttextures.com/patterns/asfalt-light.png');
            /* Subtle gray pattern */
        }

        .sidebar {
            transition: transform 0.3s ease-in-out;
        }

        .sidebar-item:hover {
            background-color: #6c757d;
            /* Medium gray hover effect */
        }

        .sidebar-item.active {
            background-color: #adb5bd;
            /* Light gray for active items */
        }

        .sidebar-header {
            font-family: 'Arial', sans-serif;
            font-size: 1.5rem;
            color:rgb(255, 255, 255);
            /* Dark gray */
            text-align: center;
        }

        .sidebar-item {
            color: #e9ecef;
            /* Light text color */
        }

        .sidebar-item i {
            color: #ced4da;
            /* Muted icon color */
        }

        .sidebar-item:hover i {
            color: #f8f9fa;
            /* Bright text color when hovered */
        }

        .bg-gray-dark {
            background-color: #343a40;
            /* Dark gray */
        }

        .bg-gray-light {
            background-color: #adb5bd;
            /* Light gray */
        }

        .bg-gray-medium {
            background-color: #6c757d;
            /* Medium gray */
        }

        .card-header {
            background-color: #6c757d;
            /* Medium gray */
            color: #f8f9fa;
            /* Light text color */
        }

        .card-body {
            background-color: #e9ecef;
            /* Very light gray */
        }
    </style>
</head>

<body class="bg-gray-50 font-sans">

    <!-- Sidebar -->
    <div class="flex">
        <!-- Sidebar Navigation -->
        <aside class="sidebar fixed top-0 left-0 h-screen w-64 bg-gray-dark text-white shadow-lg">
            <div class="p-6">
                <h2 class="sidebar-header text-2xl font-semibold mb-8">Admin Menu</h2>
                <nav>
                    <ul class="space-y-6">
                        <li>
                            <a href="{{ route('admin.dashboard') }}"
                                class="sidebar-item block py-2 px-4 rounded-md text-white hover:bg-gray-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-gray-medium' : '' }}">
                                <i class="fas fa-tachometer-alt sidebar-icon mr-3"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.products.index') }}"
                                class="sidebar-item block py-2 px-4 rounded-md text-white hover:bg-gray-medium transition {{ request()->routeIs('admin.products.index') ? 'bg-gray-medium' : '' }}">
                                <i class="fas fa-cogs sidebar-icon mr-3"></i> Products
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.allorders') }}"
                                class="sidebar-item block py-2 px-4 rounded-md text-white hover:bg-gray-medium transition {{ request()->routeIs('admin.allorders') ? 'bg-gray-medium' : '' }}">
                                <i class="fas fa-list-ul sidebar-icon mr-3"></i> View All Orders
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST" id="logout-form">
                                @csrf
                                <button type="button" onclick="document.getElementById('logout-form').submit();"
                                    class="sidebar-item block w-full text-left py-2 px-4 rounded-md text-white hover:bg-gray-medium transition bg-gray-medium">
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
            <header
                class="bg-white p-6 rounded-lg shadow-md mb-8 border border-gray-200 flex items-center justify-center">
                <h1 class="text-4xl font-bold text-gray-700">@yield('title', 'Admin Dashboard')</h1>
            </header>

            <!-- Dashboard Content -->
            <main>
                @yield('content')
            </main>
        </div>
    </div>

</body>

</html>