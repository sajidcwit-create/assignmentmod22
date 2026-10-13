@extends('layouts.app')

@section('title', $product->name . ' - ShopZone')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">

    <!-- Breadcrumb -->
    <nav class="flex text-xs text-gray-500 space-x-2">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <span>/</span>
        <a href="{{ route('products.index') }}" class="hover:text-blue-600">Products</a>
        <span>/</span>
        <a href="{{ route('products.category', $product->category->slug) }}" class="hover:text-blue-600">{{ $product->category->name }}</a>
        <span>/</span>
        <span class="text-gray-800 font-semibold truncate">{{ $product->name }}</span>
    </nav>

    <!-- Main Product Section -->
    <div class="bg-white rounded-3xl border border-gray-200 overflow-hidden shadow-sm p-6 sm:p-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            
            <!-- Left: Product Image -->
            <div class="space-y-4">
                <div class="aspect-square bg-gray-100 rounded-2xl overflow-hidden border border-gray-100 shadow-inner">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Right: Product Info & Actions -->
            <div class="flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <!-- Brand & Category -->
                    <div class="flex items-center space-x-3 text-xs uppercase font-bold tracking-wider">
                        <a href="{{ route('products.brand', $product->brand->slug) }}" class="text-blue-600 bg-blue-50 px-3 py-1 rounded-full hover:bg-blue-100 transition">
                            Brand: {{ $product->brand->name }}
                        </a>
                        <a href="{{ route('products.category', $product->category->slug) }}" class="text-gray-600 bg-gray-100 px-3 py-1 rounded-full hover:bg-gray-200 transition">
                            Category: {{ $product->category->name }}
                        </a>
                    </div>

                    <!-- Title -->
                    <h1 class="text-3xl sm:text-4xl font-black text-gray-900 leading-tight">
                        {{ $product->name }}
                    </h1>

                    <!-- Pricing -->
                    <div class="flex items-baseline space-x-4 pt-2">
                        @if($product->discount_price && $product->discount_price < $product->price)
                            <span class="text-4xl font-black text-rose-600">
                                ${{ number_format($product->discount_price, 2) }}
                            </span>
                            <span class="text-xl text-gray-400 line-through">
                                ${{ number_format($product->price, 2) }}
                            </span>
                            <span class="bg-rose-100 text-rose-700 text-xs font-black px-2.5 py-1 rounded-md">
                                Save ${{ number_format($product->price - $product->discount_price, 2) }}
                            </span>
                        @else
                            <span class="text-4xl font-black text-gray-900">
                                ${{ number_format($product->price, 2) }}
                            </span>
                        @endif
                    </div>

                    <!-- Short Description -->
                    <p class="text-gray-600 text-sm leading-relaxed border-y border-gray-100 py-4">
                        {{ $product->short_description ?? Str::limit($product->description, 150) }}
                    </p>

                    <!-- Availability & SKU -->
                    <div class="grid grid-cols-2 gap-4 text-xs">
                        <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                            <span class="text-gray-400 block mb-0.5">Availability</span>
                            @if($product->stock > 0)
                                <span class="font-bold text-emerald-600 flex items-center space-x-1">
                                    <i class="fa-solid fa-check text-xs"></i>
                                    <span>In Stock ({{ $product->stock }} units)</span>
                                </span>
                            @else
                                <span class="font-bold text-rose-600">Out of Stock</span>
                            @endif
                        </div>
                        <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                            <span class="text-gray-400 block mb-0.5">Shipping</span>
                            <span class="font-bold text-gray-700">Standard Delivery (2-3 Days)</span>
                        </div>
                    </div>
                </div>

                <!-- Actions: Add to Cart & Wishlist -->
                <div class="space-y-4 pt-4 border-t border-gray-100">
                    <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="flex items-center space-x-4">
                            <label for="quantity" class="text-xs font-bold uppercase tracking-wider text-gray-600">Quantity:</label>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                class="w-20 bg-gray-50 border border-gray-300 rounded-xl px-3 py-2 text-center text-sm font-bold focus:border-blue-500 focus:outline-none">
                        </div>

                        <div class="flex items-center space-x-4">
                            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-6 rounded-2xl shadow-lg hover:shadow-blue-500/30 transition flex items-center justify-center space-x-2">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span>Add to Shopping Cart</span>
                            </button>
                        </div>
                    </form>

                    <form action="{{ route('wishlist.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="w-full bg-gray-100 hover:bg-red-50 hover:text-red-600 text-gray-700 font-semibold py-3 px-6 rounded-2xl transition flex items-center justify-center space-x-2">
                            <i class="fa-regular fa-heart"></i>
                            <span>Add to Wishlist</span>
                        </button>
                    </form>
                </div>

            </div>

        </div>

        <!-- Full Detailed Description Section -->
        <div class="mt-12 pt-8 border-t border-gray-100">
            <h2 class="text-xl font-black text-gray-900 mb-4">Product Description & Technical Specifications</h2>
            <div class="prose max-w-none text-gray-600 text-sm leading-relaxed whitespace-pre-line">
                {{ $product->description }}
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->isNotEmpty())
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-black text-gray-900">Related Products</h2>
                <a href="{{ route('products.category', $product->category->slug) }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">
                    View More In Category
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedProducts as $rel)
                    @include('pages.products._card', ['product' => $rel])
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
