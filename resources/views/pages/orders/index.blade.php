@extends('layouts.app')

@section('title', 'Order History - ShopZone')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <div>
        <h1 class="text-3xl font-black text-gray-900">Order History</h1>
        <p class="text-sm text-gray-500 mt-1">Review all your previous purchases, payment statuses, and tracking</p>
    </div>

    @if($orders->isEmpty())
        <div class="bg-white rounded-3xl border border-gray-200 p-16 text-center shadow-sm">
            <div class="w-20 h-20 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <h2 class="text-xl font-black text-gray-900 mb-2">No Previous Orders Yet</h2>
            <p class="text-sm text-gray-500 max-w-sm mx-auto mb-6">You haven't placed any orders yet. Once you complete checkout, your order invoices will appear here.</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-full shadow transition">
                <span>Start Shopping Now</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition">
                    
                    <!-- Order Header -->
                    <div class="bg-gray-50 p-6 border-b border-gray-100 flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center space-x-4">
                            <div>
                                <span class="text-xs text-gray-400 block">Order Placed</span>
                                <span class="text-sm font-bold text-gray-900">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                            </div>
                            <div class="h-6 w-px bg-gray-200 hidden sm:block"></div>
                            <div>
                                <span class="text-xs text-gray-400 block">Order Number</span>
                                <span class="text-sm font-mono font-bold text-gray-900">{{ $order->order_number }}</span>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <!-- Payment Status Badge -->
                            <div>
                                @if($order->payment_status === 'Completed')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                        <i class="fa-solid fa-circle-check text-[10px] mr-1.5"></i> Paid
                                    </span>
                                @elseif($order->payment_status === 'Pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                        <i class="fa-solid fa-clock text-[10px] mr-1.5"></i> Pending
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800">
                                        <i class="fa-solid fa-circle-xmark text-[10px] mr-1.5"></i> {{ $order->payment_status }}
                                    </span>
                                @endif
                            </div>

                            <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center space-x-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2 rounded-xl shadow-sm transition">
                                <span>View Details</span>
                                <i class="fa-solid fa-angle-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Order Items Preview -->
                    <div class="p-6">
                        <div class="divide-y divide-gray-100">
                            @foreach($order->items as $item)
                                <div class="py-3 first:pt-0 last:pb-0 flex items-center justify-between text-sm">
                                    <div class="flex items-center space-x-3">
                                        @if($item->product)
                                            <img src="{{ $item->product->image }}" class="w-12 h-12 rounded-lg object-cover">
                                        @endif
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $item->product_name }}</p>
                                            <p class="text-xs text-gray-400">Qty: {{ $item->quantity }} × ${{ number_format($item->unit_price, 2) }}</p>
                                        </div>
                                    </div>
                                    <span class="font-bold text-gray-900">${{ number_format($item->line_total, 2) }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center text-sm font-bold">
                            <span class="text-gray-500">Total Invoice Amount:</span>
                            <span class="text-lg text-blue-600">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>

                </div>
            @endforeach

            <!-- Pagination -->
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        </div>
    @endif

</div>
@endsection
