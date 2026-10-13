@extends('layouts.app')

@section('title', 'SSLCommerz Payment Gateway - ShopZone')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">
    <div class="bg-white rounded-3xl border border-gray-200 shadow-2xl overflow-hidden">
        
        <!-- Gateway Header (SSLCommerz Branding Style) -->
        <div class="bg-gradient-to-r from-red-600 via-rose-600 to-amber-600 p-6 text-white flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-red-600 font-black text-xl shadow">
                    SSL
                </div>
                <div>
                    <h1 class="text-xl font-black">SSLCommerz Hosted Payment</h1>
                    <span class="text-xs bg-white/20 text-white px-2 py-0.5 rounded-full font-mono uppercase">SANDBOX DEMO MODE</span>
                </div>
            </div>
            <div class="text-right">
                <span class="text-xs text-white/80 block">Payable Amount</span>
                <span class="text-2xl font-black">${{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>

        <div class="p-8 space-y-6">
            
            <!-- Order & Transaction Details -->
            <div class="bg-gray-50 rounded-2xl p-5 border border-gray-200 text-xs space-y-2">
                <div class="flex justify-between text-gray-500">
                    <span>Order Reference:</span>
                    <span class="font-mono font-bold text-gray-900">{{ $order->order_number }}</span>
                </div>
                <div class="flex justify-between text-gray-500">
                    <span>Transaction ID:</span>
                    <span class="font-mono font-bold text-gray-900">{{ $order->transaction_id }}</span>
                </div>
                <div class="flex justify-between text-gray-500">
                    <span>Customer Name:</span>
                    <span class="font-bold text-gray-900">{{ $order->customer_name }}</span>
                </div>
                <div class="flex justify-between text-gray-500">
                    <span>Email & Phone:</span>
                    <span class="font-bold text-gray-900">{{ $order->customer_email }} | {{ $order->customer_phone }}</span>
                </div>
            </div>

            <!-- Demo Payment Gateway Instructions -->
            <div class="text-center space-y-2">
                <h3 class="text-sm font-bold text-gray-900">Choose Demo Simulation Action</h3>
                <p class="text-xs text-gray-500 max-w-md mx-auto">
                    This interactive gateway simulates SSLCommerz response IPN/Callback. Choose an outcome below to test order fulfillment, failure handling, or cancellation.
                </p>
            </div>

            <!-- Action Buttons for SSLCommerz Simulation -->
            <div class="space-y-3 pt-2">
                <!-- 1. Simulate Success -->
                <form action="{{ route('sslcommerz.success') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tran_id" value="{{ $order->transaction_id }}">
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 px-6 rounded-xl shadow-lg hover:shadow-emerald-500/30 transition flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Simulate Successful Payment (Instant Confirm)</span>
                    </button>
                </form>

                <!-- 2. Simulate Failure -->
                <form action="{{ route('sslcommerz.fail') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tran_id" value="{{ $order->transaction_id }}">
                    <button type="submit" class="w-full bg-rose-50 hover:bg-rose-100 text-rose-700 font-semibold py-3 px-6 rounded-xl border border-rose-200 transition flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-circle-xmark"></i>
                        <span>Simulate Failed Payment</span>
                    </button>
                </form>

                <!-- 3. Simulate Cancel -->
                <form action="{{ route('sslcommerz.cancel') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tran_id" value="{{ $order->transaction_id }}">
                    <button type="submit" class="w-full bg-gray-50 hover:bg-gray-100 text-gray-600 font-semibold py-3 px-6 rounded-xl border border-gray-200 transition flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-ban"></i>
                        <span>Cancel Transaction & Return</span>
                    </button>
                </form>
            </div>

            <div class="border-t pt-4 text-center text-[11px] text-gray-400">
                🔒 256-Bit SSL Encrypted Demo Gateway &bull; Complies with Bangladesh Bank Payment Security Standards
            </div>

        </div>

    </div>
</div>
@endsection
