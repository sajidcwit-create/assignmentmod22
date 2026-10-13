@extends('layouts.app')

@section('title', 'Shopping Cart - ShopZone')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <div>
        <h1 class="text-3xl font-black text-gray-900">Shopping Cart</h1>
        <p class="text-sm text-gray-500 mt-1">Review your selected items before proceeding to checkout</p>
    </div>

    @if($cartItems->isEmpty())
        <div class="bg-white rounded-3xl border border-gray-200 p-16 text-center shadow-sm">
            <div class="w-20 h-20 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <h2 class="text-xl font-black text-gray-900 mb-2">Your Shopping Cart is Empty</h2>
            <p class="text-sm text-gray-500 max-w-sm mx-auto mb-6">Looks like you haven't added anything to your cart yet. Discover hot deals and top tech gadgets now!</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-full shadow transition">
                <span>Browse Products</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Cart Items List (Left 2 Cols) -->
            <div class="lg:col-span-2 space-y-4">
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm divide-y divide-gray-100">
                    @foreach($cartItems as $item)
                        <div class="p-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <!-- Image & Name -->
                            <div class="flex items-center space-x-4 w-full sm:w-auto">
                                <div class="w-20 h-20 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0 border border-gray-100">
                                    <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <span class="text-xs font-bold uppercase text-gray-400">{{ $item->product->brand->name ?? '' }}</span>
                                    <h3 class="text-sm font-bold text-gray-900 hover:text-blue-600">
                                        <a href="{{ route('products.show', $item->product->slug) }}">{{ $item->product->name }}</a>
                                    </h3>
                                    <p class="text-xs text-gray-500 mt-0.5">Unit Price: ${{ number_format($item->price, 2) }}</p>
                                </div>
                            </div>

                            <!-- Quantity & Update Form -->
                            <div class="flex items-center justify-between sm:justify-end space-x-6 w-full sm:w-auto">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    @method('PUT')
                                    <label for="quantity-{{ $item->id }}" class="text-xs text-gray-400 font-medium">Qty:</label>
                                    <input type="number" name="quantity" id="quantity-{{ $item->id }}" value="{{ $item->quantity }}" min="1" max="50"
                                        class="w-16 bg-gray-50 border border-gray-300 rounded-lg py-1 px-2 text-center text-sm font-bold focus:border-blue-500 focus:outline-none"
                                        onchange="this.form.submit()">
                                </form>

                                <!-- Item Total -->
                                <div class="text-right min-w-[80px]">
                                    <span class="block text-sm font-black text-gray-900">${{ number_format($item->subtotal, 2) }}</span>
                                </div>

                                <!-- Remove Button -->
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-rose-500 p-2 transition" title="Remove Item">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-between items-center pt-2">
                    <a href="{{ route('products.index') }}" class="text-sm text-blue-600 hover:underline flex items-center space-x-1">
                        <i class="fa-solid fa-arrow-left text-xs"></i>
                        <span>Continue Shopping</span>
                    </a>
                </div>
            </div>

            <!-- Order Summary (Right Column) -->
            <div>
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-6 sticky top-28">
                    <h2 class="text-lg font-black text-gray-900 border-b pb-3">Order Summary</h2>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-bold text-gray-900">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Estimated Tax (5%)</span>
                            <span>${{ number_format($tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Shipping</span>
                            @if($shipping == 0)
                                <span class="font-bold text-emerald-600">FREE</span>
                            @else
                                <span>${{ number_format($shipping, 2) }}</span>
                            @endif
                        </div>
                        <div class="border-t pt-3 flex justify-between text-base font-black text-gray-900">
                            <span>Total Payable</span>
                            <span class="text-xl text-blue-600">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg hover:shadow-blue-500/30 transition flex items-center justify-center space-x-2">
                        <span>Proceed to Checkout</span>
                        <i class="fa-solid fa-lock text-xs"></i>
                    </a>

                    <div class="text-[11px] text-gray-400 text-center flex items-center justify-center space-x-1">
                        <i class="fa-solid fa-shield text-emerald-500"></i>
                        <span>SSLCommerz Secured Checkout</span>
                    </div>
                </div>
            </div>

        </div>
    @endif

</div>
@endsection
