@extends('layouts.app')

@section('title', 'Checkout - ShopZone')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <div>
        <h1 class="text-3xl font-black text-gray-900">Secure Checkout</h1>
        <p class="text-sm text-gray-500 mt-1">Please provide your shipping and billing details to proceed to SSLCommerz</p>
    </div>

    <form action="{{ route('checkout.initiate') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left 2 Cols: Shipping Details -->
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white rounded-2xl border border-gray-200 p-6 sm:p-8 shadow-sm space-y-6">
                    <div class="flex items-center space-x-3 border-b pb-4">
                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 font-bold flex items-center justify-center text-sm">
                            1
                        </div>
                        <h2 class="text-lg font-black text-gray-900">Customer & Shipping Information</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="customer_name" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="customer_name" id="customer_name" required 
                                value="{{ old('customer_name', $user->name) }}"
                                class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:border-blue-500 focus:outline-none">
                        </div>

                        <div>
                            <label for="customer_email" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">Email Address</label>
                            <input type="email" name="customer_email" id="customer_email" required 
                                value="{{ old('customer_email', $user->email) }}"
                                class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:border-blue-500 focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="customer_phone" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">Phone Number</label>
                            <input type="text" name="customer_phone" id="customer_phone" required 
                                value="{{ old('customer_phone', $user->phone ?? '+8801712345678') }}" placeholder="+880 1..."
                                class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:border-blue-500 focus:outline-none">
                        </div>

                        <div>
                            <label for="city" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">City / Division</label>
                            <input type="text" name="city" id="city" required 
                                value="{{ old('city', $user->city ?? 'Dhaka') }}" placeholder="e.g. Dhaka"
                                class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:border-blue-500 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label for="shipping_address" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">Full Delivery Address</label>
                        <textarea name="shipping_address" id="shipping_address" rows="3" required 
                            class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:border-blue-500 focus:outline-none"
                            placeholder="House / Flat #, Road, Police Station, Postal Area">{{ old('shipping_address', $user->address ?? 'House 12, Road 4, Dhanmondi') }}</textarea>
                    </div>
                </div>

                <!-- Payment Method Section -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6 sm:p-8 shadow-sm space-y-4">
                    <div class="flex items-center space-x-3 border-b pb-4">
                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 font-bold flex items-center justify-center text-sm">
                            2
                        </div>
                        <h2 class="text-lg font-black text-gray-900">Payment Gateway</h2>
                    </div>

                    <div class="p-4 rounded-xl border-2 border-blue-500 bg-blue-50/40 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <input type="radio" name="payment_method" value="SSLCommerz" checked class="text-blue-600 focus:ring-blue-500 h-4 w-4">
                            <div>
                                <span class="block text-sm font-bold text-gray-900">SSLCommerz Hosted Payment Gateway</span>
                                <span class="text-xs text-gray-500">Pay securely via Cards, bKash, Nagad, Rocket, or Internet Banking</span>
                            </div>
                        </div>
                        <span class="bg-blue-600 text-white text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded">
                            Demo Sandbox
                        </span>
                    </div>
                </div>

            </div>

            <!-- Right Col: Order Summary & Place Order -->
            <div>
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-6 sticky top-28">
                    <h2 class="text-lg font-black text-gray-900 border-b pb-3">Items in Order ({{ $cartItems->count() }})</h2>

                    <!-- Items mini list -->
                    <div class="space-y-3 max-h-60 overflow-y-auto pr-1 divide-y divide-gray-100 text-xs">
                        @foreach($cartItems as $item)
                            <div class="pt-2 first:pt-0 flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <img src="{{ $item->product->image }}" class="w-9 h-9 rounded object-cover">
                                    <div class="max-w-[140px]">
                                        <p class="font-bold text-gray-800 truncate">{{ $item->product->name }}</p>
                                        <p class="text-gray-400">Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                                    </div>
                                </div>
                                <span class="font-bold text-gray-900">${{ number_format($item->subtotal, 2) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Cost Breakdown -->
                    <div class="border-t pt-4 space-y-2.5 text-sm">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-bold text-gray-900">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Tax (5%)</span>
                            <span>${{ number_format($tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Delivery</span>
                            <span class="font-bold {{ $shipping == 0 ? 'text-emerald-600' : 'text-gray-900' }}">
                                {{ $shipping == 0 ? 'FREE' : '$' . number_format($shipping, 2) }}
                            </span>
                        </div>
                        <div class="border-t pt-3 flex justify-between text-base font-black text-gray-900">
                            <span>Total</span>
                            <span class="text-2xl text-blue-600">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-4 rounded-xl shadow-xl hover:shadow-blue-500/30 transition flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-lock"></i>
                        <span>Pay with SSLCommerz (${{ number_format($total, 2) }})</span>
                    </button>

                    <p class="text-[11px] text-gray-400 text-center">
                        You will be redirected to the demo SSLCommerz payment portal to simulate instant payment confirmation.
                    </p>
                </div>
            </div>

        </div>
    </form>

</div>
@endsection
