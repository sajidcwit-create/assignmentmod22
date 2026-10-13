<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ShopZone') - Modern E-Commerce Platform</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <!-- Top Notification / Announcement Bar -->
    <div class="bg-gradient-to-r from-blue-700 to-indigo-800 text-white text-xs sm:text-sm py-2 px-4 text-center font-medium shadow-inner flex justify-between items-center max-w-full">
        <div class="hidden sm:block">🌟 Free express delivery on orders over $1,000!</div>
        <div class="mx-auto sm:mx-0">🎉 Welcome to ShopZone E-Commerce - Powered by Laravel 12 & SSLCommerz Demo</div>
        <div class="hidden md:flex items-center space-x-3 text-xs">
            <span><i class="fa-solid fa-phone mr-1"></i> +880 1700-000000</span>
            <span><i class="fa-solid fa-headset mr-1"></i> 24/7 Support</span>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center space-x-3">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                        <div class="w-11 h-11 bg-blue-600 rounded-xl flex items-center justify-center text-white text-2xl shadow-md group-hover:scale-105 transition-transform duration-200">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </div>
                        <div>
                            <span class="text-2xl font-black tracking-tight text-gray-900 group-hover:text-blue-600 transition">Shop<span class="text-blue-600">Zone</span></span>
                            <span class="block text-[10px] uppercase font-bold tracking-widest text-gray-400 -mt-1">Premium Store</span>
                        </div>
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-lg mx-8">
                    <form action="{{ route('products.index') }}" method="GET" class="w-full relative">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Search products, brands, models..." 
                            class="w-full bg-gray-100 text-sm text-gray-900 pl-11 pr-24 py-3 rounded-full border border-transparent focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 transition shadow-inner">
                        <div class="absolute left-4 top-3.5 text-gray-400">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <button type="submit" class="absolute right-1.5 top-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-full transition shadow">
                            Search
                        </button>
                    </form>
                </div>

                <!-- Navigation Links & User Actions -->
                <div class="flex items-center space-x-3 sm:space-x-5">
                    
                    <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-blue-600 font-medium text-sm hidden lg:inline-flex items-center space-x-1 transition">
                        <span>All Products</span>
                    </a>

                    <!-- Wishlist Link -->
                    <a href="{{ route('wishlist.index') }}" class="relative p-2 text-gray-600 hover:text-red-500 hover:bg-red-50 rounded-full transition duration-150" title="Wishlist">
                        <i class="fa-regular fa-heart text-xl"></i>
                        @auth
                            @php $wCount = auth()->user()->wishlists()->count(); @endphp
                            @if($wCount > 0)
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-500 rounded-full">
                                    {{ $wCount }}
                                </span>
                            @endif
                        @endauth
                    </a>

                    <!-- Shopping Cart Link -->
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-full transition duration-150" title="Shopping Cart">
                        <i class="fa-solid fa-cart-shopping text-xl"></i>
                        @auth
                            @php $cCount = auth()->user()->cartItems()->count(); @endphp
                            @if($cCount > 0)
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-blue-600 rounded-full animate-pulse">
                                    {{ $cCount }}
                                </span>
                            @endif
                        @endauth
                    </a>

                    <!-- Auth Section -->
                    @auth
                        <div class="relative group">
                            <button class="flex items-center space-x-2 text-sm font-semibold text-gray-800 bg-gray-100 hover:bg-gray-200 px-3 py-2 rounded-full transition">
                                <div class="w-7 h-7 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-xs uppercase">
                                    {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                                </div>
                                <span class="max-w-[100px] truncate hidden sm:inline">{{ auth()->user()->name ?? 'Account' }}</span>
                                <i class="fa-solid fa-chevron-down text-xs text-gray-500"></i>
                            </button>

                            <!-- Dropdown menu -->
                            <div class="absolute right-0 mt-1 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-2 hidden group-hover:block hover:block z-50">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-xs text-gray-400">Signed in as</p>
                                    <p class="text-xs font-bold text-gray-900 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                                    <i class="fa-regular fa-user mr-2"></i> My Profile
                                </a>
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                                    <i class="fa-solid fa-box mr-2"></i> Order History
                                </a>
                                <a href="{{ route('wishlist.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                                    <i class="fa-regular fa-heart mr-2"></i> My Wishlist
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center space-x-1.5 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm px-4 py-2.5 rounded-full shadow-sm transition">
                            <i class="fa-solid fa-key text-xs"></i>
                            <span>OTP Login</span>
                        </a>
                    @endauth

                </div>
            </div>
        </div>

        <!-- Mobile Search Bar -->
        <div class="md:hidden px-4 pb-3">
            <form action="{{ route('products.index') }}" method="GET" class="w-full relative">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Search products..." 
                    class="w-full bg-gray-100 text-sm text-gray-900 pl-10 pr-20 py-2.5 rounded-full border border-transparent focus:border-blue-500 focus:bg-white focus:outline-none">
                <div class="absolute left-3.5 top-3 text-gray-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <button type="submit" class="absolute right-1 top-1 bg-blue-600 text-white text-xs font-semibold px-3 py-1.5 rounded-full">
                    Search
                </button>
            </form>
        </div>
    </header>

    <!-- Global Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('status'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r-lg shadow-sm flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                    <span class="text-sm font-medium">{{ session('status') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('info'))
            <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-800 p-4 rounded-r-lg shadow-sm flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-circle-info text-blue-500 text-lg"></i>
                    <span class="text-sm font-medium">{{ session('info') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-blue-500 hover:text-blue-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('error') || $errors->any())
            <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 p-4 rounded-r-lg shadow-sm flex items-start justify-between mb-4">
                <div class="flex items-start space-x-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg mt-0.5"></i>
                    <div>
                        @if(session('error'))
                            <p class="text-sm font-medium">{{ session('error') }}</p>
                        @endif
                        @if($errors->any())
                            <ul class="text-sm list-disc list-inside mt-1 space-y-0.5">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif
    </div>

    <!-- Main Content Slot -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 mt-16 pt-12 pb-8 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center text-white text-xl">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </div>
                        <span class="text-2xl font-black text-white">Shop<span class="text-blue-500">Zone</span></span>
                    </div>
                    <p class="text-sm text-gray-400 mb-4">
                        Modern E-Commerce Web Application built with Laravel 12, MySQL, OTP Authentication, and SSLCommerz Payment Gateway.
                    </p>
                    <div class="flex space-x-3 text-gray-400">
                        <a href="#" class="w-8 h-8 rounded-full bg-gray-800 hover:bg-blue-600 hover:text-white flex items-center justify-center transition"><i class="fa-brands fa-facebook-f text-xs"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-gray-800 hover:bg-sky-500 hover:text-white flex items-center justify-center transition"><i class="fa-brands fa-twitter text-xs"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-gray-800 hover:bg-pink-600 hover:text-white flex items-center justify-center transition"><i class="fa-brands fa-instagram text-xs"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-gray-800 hover:bg-gray-700 hover:text-white flex items-center justify-center transition"><i class="fa-brands fa-github text-xs"></i></a>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-white mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-blue-400 transition">Home</a></li>
                        <li><a href="{{ route('products.index') }}" class="hover:text-blue-400 transition">All Products</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-blue-400 transition">Shopping Cart</a></li>
                        <li><a href="{{ route('wishlist.index') }}" class="hover:text-blue-400 transition">Wishlist</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-white mb-4">Account & Orders</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('login') }}" class="hover:text-blue-400 transition">OTP Login</a></li>
                        <li><a href="{{ route('profile') }}" class="hover:text-blue-400 transition">User Profile</a></li>
                        <li><a href="{{ route('orders.index') }}" class="hover:text-blue-400 transition">Order History</a></li>
                        <li><a href="{{ route('checkout.index') }}" class="hover:text-blue-400 transition">Checkout Demo</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-white mb-4">Payment & Security</h3>
                    <p class="text-xs text-gray-400 mb-3">
                        Integrated with SSLCommerz Demo Payment Gateway sandbox supporting Cards, Mobile Banking & Net Banking.
                    </p>
                    <div class="flex flex-wrap gap-2 text-xs text-gray-400">
                        <span class="bg-gray-800 px-2.5 py-1 rounded border border-gray-700 font-mono">SSLCommerz</span>
                        <span class="bg-gray-800 px-2.5 py-1 rounded border border-gray-700 font-mono">bKash</span>
                        <span class="bg-gray-800 px-2.5 py-1 rounded border border-gray-700 font-mono">Nagad</span>
                        <span class="bg-gray-800 px-2.5 py-1 rounded border border-gray-700 font-mono">VISA/MasterCard</span>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-6 text-center text-xs text-gray-500">
                &copy; {{ date('Y') }} ShopZone E-Commerce Application. All rights reserved. Built with Laravel & MySQL.
            </div>
        </div>
    </footer>

</body>
</html>
