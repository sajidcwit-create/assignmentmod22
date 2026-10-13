@extends('layouts.app')

@section('title', 'Order Details #' . $order->order_number . ' - ShopZone')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <!-- Top Back Button & Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('orders.index') }}" class="text-xs text-blue-600 hover:underline flex items-center space-x-1">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to All Orders</span>
        </a>

        <button onclick="window.print()" class="text-xs text-gray-600 bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg transition flex items-center space-x-1.5">
            <i class="fa-solid fa-print"></i>
            <span>Print Invoice</span>
        </button>
    </div>

    <!-- Invoice Card -->
    <div class="bg-white rounded-3xl border border-gray-200 shadow-xl overflow-hidden">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-8 text-white flex flex-wrap items-center justify-between gap-4">
            <div>
                <span class="text-xs text-gray-400 uppercase font-mono block">Order Reference</span>
                <h1 class="text-2xl font-mono font-black text-white">{{ $order->order_number }}</h1>
                <p class="text-xs text-gray-400 mt-1">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
            </div>

            <div class="text-right">
                <span class="text-xs text-gray-400 block mb-1">Payment Status</span>
                @if($order->payment_status === 'Completed')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                        <i class="fa-solid fa-circle-check text-[10px] mr-1.5"></i> Paid & Confirmed
                    </span>
                @elseif($order->payment_status === 'Pending')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                        <i class="fa-solid fa-clock text-[10px] mr-1.5"></i> Payment Pending
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-500/20 text-rose-300 border border-rose-500/30">
                        <i class="fa-solid fa-circle-xmark text-[10px] mr-1.5"></i> {{ $order->payment_status }}
                    </span>
                @endif
            </div>
        </div>

        <div class="p-8 space-y-8">
            
            <!-- Customer & Shipping Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-2xl border border-gray-100 text-xs">
                <div>
                    <h3 class="font-bold text-gray-400 uppercase tracking-wider mb-2">Shipping Information</h3>
                    <p class="font-bold text-gray-900 text-sm mb-1">{{ $order->customer_name }}</p>
                    <p class="text-gray-600">{{ $order->shipping_address }}</p>
                    <p class="text-gray-600">{{ $order->city }}</p>
                    <p class="text-gray-600 mt-1"><i class="fa-solid fa-phone text-gray-400 mr-1"></i> {{ $order->customer_phone }}</p>
                    <p class="text-gray-600"><i class="fa-regular fa-envelope text-gray-400 mr-1"></i> {{ $order->customer_email }}</p>
                </div>

                <div class="border-t md:border-t-0 md:border-l md:pl-6 pt-4 md:pt-0 border-gray-200">
                    <h3 class="font-bold text-gray-400 uppercase tracking-wider mb-2">Payment Transaction</h3>
                    <p class="text-gray-600 mb-1"><span class="text-gray-400">Gateway:</span> <span class="font-bold text-gray-900">{{ $order->payment_method }}</span></p>
                    <p class="text-gray-600 mb-1"><span class="text-gray-400">Transaction ID:</span> <span class="font-mono font-bold text-gray-900">{{ $order->transaction_id ?? 'N/A' }}</span></p>
                    <p class="text-gray-600 mb-1"><span class="text-gray-400">Order Status:</span> <span class="font-bold text-blue-600">{{ $order->order_status }}</span></p>
                </div>
            </div>

            <!-- Items Table -->
            <div>
                <h3 class="text-base font-black text-gray-900 mb-4">Purchased Items</h3>
                <div class="border border-gray-200 rounded-2xl overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                        <thead class="bg-gray-50 text-gray-500 text-xs font-bold uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-3">Product</th>
                                <th class="px-6 py-3 text-center">Unit Price</th>
                                <th class="px-6 py-3 text-center">Quantity</th>
                                <th class="px-6 py-3 text-right">Line Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="px-6 py-4 flex items-center space-x-3">
                                        @if($item->product)
                                            <img src="{{ $item->product->image }}" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                                        @endif
                                        <span class="font-bold text-gray-900">{{ $item->product_name }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center text-gray-600">${{ number_format($item->unit_price, 2) }}</td>
                                    <td class="px-6 py-4 text-center font-bold text-gray-900">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 text-right font-black text-gray-900">${{ number_format($item->line_total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 border-t border-gray-200 text-sm">
                            <tr>
                                <td colspan="3" class="px-6 py-3 text-right font-bold text-gray-600">Total Invoice Amount:</td>
                                <td class="px-6 py-3 text-right text-lg font-black text-blue-600">${{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Help & Support -->
            <div class="bg-blue-50/50 rounded-2xl p-4 border border-blue-100 text-xs text-blue-900 flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-headset text-blue-500 text-base"></i>
                    <span>Need support with this order? Email us at <span class="font-bold">support@shopzone.demo</span></span>
                </div>
                <a href="{{ route('home') }}" class="font-bold text-blue-600 hover:underline">Continue Shopping</a>
            </div>

        </div>

    </div>

</div>
@endsection
