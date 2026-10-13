@extends('layouts.app')

@section('title', 'User Profile - ShopZone')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    
    <!-- Profile Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-8 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center space-x-5">
            <div class="w-20 h-20 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center text-3xl font-black uppercase shadow-inner border border-white/20">
                {{ substr($user->name ?? 'U', 0, 1) }}
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-black">{{ $user->name ?? 'Valued Customer' }}</h1>
                <p class="text-blue-100 text-sm flex items-center gap-2 mt-1">
                    <i class="fa-regular fa-envelope"></i>
                    <span>{{ $user->email }}</span>
                </p>
                <div class="mt-2 inline-flex items-center space-x-1.5 bg-emerald-500/20 text-emerald-200 border border-emerald-400/30 text-xs px-2.5 py-0.5 rounded-full font-semibold">
                    <i class="fa-solid fa-circle-check text-[10px]"></i>
                    <span>OTP Verified Member</span>
                </div>
            </div>
        </div>

        <!-- Quick Summary Stats -->
        <div class="flex items-center space-x-4 bg-white/10 backdrop-blur rounded-2xl p-4 border border-white/10">
            <div class="text-center px-3">
                <span class="block text-2xl font-black">{{ $ordersCount }}</span>
                <span class="text-[11px] text-blue-100 uppercase tracking-wider">Orders</span>
            </div>
            <div class="h-8 w-px bg-white/20"></div>
            <div class="text-center px-3">
                <span class="block text-2xl font-black">{{ $wishlistsCount }}</span>
                <span class="text-[11px] text-blue-100 uppercase tracking-wider">Wishlist</span>
            </div>
            <div class="h-8 w-px bg-white/20"></div>
            <div class="text-center px-3">
                <span class="block text-2xl font-black">{{ $cartCount }}</span>
                <span class="text-[11px] text-blue-100 uppercase tracking-wider">In Cart</span>
            </div>
        </div>
    </div>

    <!-- Profile Edit & Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- Left Sidebar Navigation -->
        <div class="space-y-4">
            <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm space-y-1">
                <a href="{{ route('profile') }}" class="flex items-center space-x-3 text-sm font-bold text-blue-600 bg-blue-50 px-4 py-3 rounded-xl transition">
                    <i class="fa-regular fa-user"></i>
                    <span>Profile Details</span>
                </a>
                <a href="{{ route('orders.index') }}" class="flex items-center space-x-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 px-4 py-3 rounded-xl transition">
                    <i class="fa-solid fa-box"></i>
                    <span>Order History ({{ $ordersCount }})</span>
                </a>
                <a href="{{ route('wishlist.index') }}" class="flex items-center space-x-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 px-4 py-3 rounded-xl transition">
                    <i class="fa-regular fa-heart"></i>
                    <span>My Wishlist ({{ $wishlistsCount }})</span>
                </a>
                <a href="{{ route('cart.index') }}" class="flex items-center space-x-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 px-4 py-3 rounded-xl transition">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span>Shopping Cart ({{ $cartCount }})</span>
                </a>
                <div class="border-t pt-2 mt-2">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left flex items-center space-x-3 text-sm font-semibold text-rose-600 hover:bg-rose-50 px-4 py-3 rounded-xl transition">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <span>Sign Out</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Content: Profile Update Form -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm space-y-6">
                <div>
                    <h2 class="text-xl font-black text-gray-900">Personal Information</h2>
                    <p class="text-xs text-gray-500">Update your delivery address, phone, and profile details</p>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="name" id="name" required value="{{ old('name', $user->name) }}"
                                class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:border-blue-500 focus:outline-none">
                        </div>

                        <div>
                            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">Email Address</label>
                            <input type="email" id="email" disabled value="{{ $user->email }}"
                                class="w-full bg-gray-100 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-500 cursor-not-allowed">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">Phone Number</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" placeholder="+880 1..."
                                class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:border-blue-500 focus:outline-none">
                        </div>

                        <div>
                            <label for="city" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">City / Region</label>
                            <input type="text" name="city" id="city" value="{{ old('city', $user->city) }}" placeholder="e.g. Dhaka"
                                class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:border-blue-500 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label for="address" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">Street Address</label>
                        <textarea name="address" id="address" rows="3" placeholder="House, Road, Area..."
                            class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:border-blue-500 focus:outline-none">{{ old('address', $user->address) }}</textarea>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2.5 rounded-xl shadow transition">
                            Save Profile Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
@endsection
