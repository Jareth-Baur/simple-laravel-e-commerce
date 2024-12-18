<nav x-data="{ open: false }" class="bg-gradient-to-r from-red-600 to-green-500 shadow-md border-b border-gray-200">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Left Section (Logo and Navigation Links) -->
            <div class="flex items-center space-x-10">
                <!-- Logo -->
                <div class="shrink-0">
                    <a href="{{ route('dashboard') }}" class="text-white font-bold text-2xl flex items-center">
                        <i class="fas fa-gift mr-3 text-blue-400"></i> <!-- Christmas Gift Icon -->
                        <span class="hidden md:block">Holiday Fitness Store</span>
                    </a>
                </div>

                <!-- Navigation Links (Desktop View) -->
                <div class="hidden sm:flex space-x-8">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-red-300 transition duration-300 ease-in-out">
                        <i class="fas fa-home text-black-300 mr-2"></i> {{ __('HOME') }}
                    </x-nav-link>
                    <x-nav-link :href="route('products.show')" :active="request()->routeIs('products.show')" class="text-white hover:text-red-300 transition duration-300 ease-in-out">
                        <i class="fas fa-cogs text-violet-300 mr-2"></i> {{ __('PRODUCTS') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Right Section (Cart, Favorite, Orders, Profile, and Log Out) -->
            <div class="hidden sm:flex items-center space-x-8">
                <!-- Cart Icon -->
                <a href="{{ route('cart.view') }}" class="btn btn-link position-relative">
                    <i class="fas fa-shopping-cart fa-2x text-white hover:text-red-300 transition duration-300 ease-in-out"></i>
                </a>

                <!-- Favorite Icon -->
                <a href="{{ route('favoritesindex') }}" class="btn btn-link">
                    <i class="fas fa-heart fa-2x text-white hover:text-red-300 transition duration-300 ease-in-out"></i>
                </a>

                <!-- My Orders Icon -->
                <a href="{{ route('Order_List') }}" class="btn btn-link">
                    <i class="fas fa-box fa-2x text-white hover:text-red-300 transition duration-300 ease-in-out"></i>
                </a>

                <!-- Profile Icon -->
                <a href="{{ route('profile.edit') }}" class="btn btn-link">
                    <i class="fas fa-user-circle fa-2x text-white hover:text-red-300 transition duration-300 ease-in-out"></i>
                </a>

                <!-- Log Out -->
                <form method="POST" action="{{ route('logout') }}" class="inline-block">
                    @csrf
                    <button type="submit" class="text-white hover:text-red-300 font-medium flex items-center">
                        <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Log Out') }}
                    </button>
                </form>
            </div>

            <!-- Hamburger Menu (Mobile View) -->
            <div class="-mr-2 flex sm:hidden">
                <button @click="open = ! open" class="text-white p-2 rounded-md focus:outline-none">
                    <i :class="open ? 'fas fa-times' : 'fas fa-bars'" class="text-2xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="sm:hidden bg-gray-800 border-t border-gray-700">
        <div class="pt-4 pb-3 space-y-3">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-red-300 transition duration-300 ease-in-out">
                <i class="fas fa-home text-yellow-300 mr-2"></i> {{ __('HOME') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('products.show')" :active="request()->routeIs('products.show')" class="text-white hover:text-red-300 transition duration-300 ease-in-out">
                <i class="fas fa-cogs text-yellow-300 mr-2"></i> {{ __('PRODUCTS') }}
            </x-responsive-nav-link>
            <!-- Responsive Favorite Link -->
            <x-responsive-nav-link :href="route('favoritesindex')" class="text-white hover:text-red-300 transition duration-300 ease-in-out">
                <i class="fas fa-heart text-yellow-300 mr-2"></i> {{ __('Favorite') }}
            </x-responsive-nav-link>
            <!-- Responsive My Orders Link -->
            <x-responsive-nav-link :href="route('Order_List')" class="text-white hover:text-red-300 transition duration-300 ease-in-out">
                <i class="fas fa-box text-yellow-300 mr-2"></i> {{ __('My Orders') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-2 border-t border-gray-700">
            <div class="mt-3 space-y-3">
                <!-- Log Out -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-white hover:text-red-300 transition duration-300 ease-in-out">
                        <i class="fas fa-sign-out-alt text-yellow-300 mr-2"></i> {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
