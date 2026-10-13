@extends('layouts.app')

@section('title', 'All Products - ShopZone')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <nav class="flex text-xs text-gray-500 mb-2 space-x-2">
            <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
            <span>/</span>
            <span class="text-gray-800 font-semibold">
                @if(isset($currentCategory))
                    Category: {{ $currentCategory->name }}
                @elseif(isset($currentBrand))
                    Brand: {{ $currentBrand->name }}
                @elseif(request('search'))
                    Search: "{{ request('search') }}"
                @else
                    All Products
                @endif
            </span>
        </nav>
        <h1 class="text-3xl font-black text-gray-900">
            @if(isset($currentCategory))
                {{ $currentCategory->name }} Products
            @elseif(isset($currentBrand))
                {{ $currentBrand->name }} Collection
            @elseif(request('search'))
                Search results for "{{ request('search') }}"
            @else
                Discover Products
            @endif
        </h1>
        <p class="text-sm text-gray-500 mt-1">Found {{ $products->total() }} items matching your criteria</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Filters Sidebar -->
        <aside class="space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-6">
                <div class="flex items-center justify-between border-b pb-3">
                    <h3 class="font-bold text-gray-900">Filters</h3>
                    <a href="{{ route('products.index') }}" class="text-xs text-blue-600 hover:underline">Reset All</a>
                </div>

                <!-- Categories Filter -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">Categories</h4>
                    <ul class="space-y-2 text-sm">
                        <li>
                            <a href="{{ route('products.index') }}" class="flex items-center justify-between {{ !request('category') && !isset($currentCategory) ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-600' }}">
                                <span>All Categories</span>
                            </a>
                        </li>
                        @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('products.category', $cat->slug) }}" class="flex items-center justify-between {{ (isset($currentCategory) && $currentCategory->id === $cat->id) || request('category') == $cat->slug ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-600' }}">
                                    <span>{{ $cat->name }}</span>
                                    <span class="text-xs text-gray-400">({{ $cat->products_count }})</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Brands Filter -->
                <div class="border-t pt-4">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">Brands</h4>
                    <ul class="space-y-2 text-sm">
                        <li>
                            <a href="{{ route('products.index') }}" class="flex items-center justify-between {{ !request('brand') && !isset($currentBrand) ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-600' }}">
                                <span>All Brands</span>
                            </a>
                        </li>
                        @foreach($brands as $b)
                            <li>
                                <a href="{{ route('products.brand', $b->slug) }}" class="flex items-center justify-between {{ (isset($currentBrand) && $currentBrand->id === $b->id) || request('brand') == $b->slug ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-600' }}">
                                    <span>{{ $b->name }}</span>
                                    <span class="text-xs text-gray-400">({{ $b->products_count }})</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Sort Filter -->
                <div class="border-t pt-4">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">Sort By</h4>
                    <form action="{{ url()->current() }}" method="GET" class="space-y-2">
                        @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                        @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                        @if(request('brand')) <input type="hidden" name="brand" value="{{ request('brand') }}"> @endif
                        <select name="sort" onchange="this.form.submit()" class="w-full text-sm border-gray-300 rounded-xl bg-gray-50 p-2.5 focus:border-blue-500 focus:bg-white focus:outline-none">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Arrivals</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Product Grid & Pagination -->
        <main class="lg:col-span-3 space-y-6">
            @if($products->isEmpty())
                <div class="bg-white rounded-2xl p-12 text-center border border-gray-200">
                    <div class="w-16 h-16 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">No products found</h3>
                    <p class="text-sm text-gray-500 mb-6">We couldn't find any products matching your selected criteria.</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center space-x-2 bg-blue-600 text-white text-sm font-semibold px-5 py-2.5 rounded-full shadow hover:bg-blue-700 transition">
                        <span>Clear Filters</span>
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        @include('pages.products._card', ['product' => $product])
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </main>

    </div>

</div>
@endsection
