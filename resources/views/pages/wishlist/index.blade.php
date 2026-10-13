@extends('layouts.app')

@section('title', 'My Wishlist - ShopZone')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <div>
        <h1 class="text-3xl font-black text-gray-900">My Wishlist</h1>
        <p class="text-sm text-gray-500 mt-1">Saved items you want to buy later</p>
    </div>

    @if($wishlists->isEmpty())
        <div class="bg-white rounded-3xl border border-gray-200 p-16 text-center shadow-sm">
            <div class="w-20 h-20 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                <i class="fa-regular fa-heart"></i>
            </div>
            <h2 class="text-xl font-black text-gray-900 mb-2">Your Wishlist is Empty</h2>
            <p class="text-sm text-gray-500 max-w-sm mx-auto mb-6">Explore our curated collections and save items you adore with a single click.</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-full shadow transition">
                <span>Discover Products</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($wishlists as $item)
                <div class="bg-white rounded-2xl border border-gray-100 hover:border-gray-200 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group relative">
                    <!-- Image -->
                    <div class="relative bg-gray-100 aspect-square overflow-hidden">
                        <a href="{{ route('products.show', $item->product->slug) }}">
                            <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                        </a>

                        <!-- Remove Button -->
                        <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" class="absolute top-3 right-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-8 h-8 rounded-full bg-white/90 hover:bg-rose-500 hover:text-white text-gray-500 flex items-center justify-center shadow transition" title="Remove from wishlist">
                                <i class="fa-solid fa-xmark text-sm"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Details -->
                    <div class="p-5 flex flex-col flex-grow">
                        <span class="text-[11px] font-bold uppercase text-gray-400 mb-1">{{ $item->product->brand->name ?? '' }}</span>
                        <h3 class="text-sm font-bold text-gray-900 group-hover:text-blue-600 transition line-clamp-2 mb-2">
                            <a href="{{ route('products.show', $item->product->slug) }}">{{ $item->product->name }}</a>
                        </h3>

                        <div class="pt-3 border-t border-gray-100 flex items-center justify-between mt-auto">
                            <div class="text-base font-black text-gray-900">
                                ${{ number_format($item->product->effective_price, 2) }}
                            </div>

                            <!-- Move to Cart -->
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-3 py-2 rounded-xl shadow transition flex items-center space-x-1">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                    <span>Move to Cart</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
