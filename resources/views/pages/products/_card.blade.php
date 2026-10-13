<div class="bg-white rounded-2xl border border-gray-100 hover:border-gray-200 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group">
    
    <!-- Image & Badges -->
    <div class="relative bg-gray-100 aspect-square overflow-hidden">
        <a href="{{ route('products.show', $product->slug) }}">
            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        </a>

        <!-- Badges -->
        <div class="absolute top-3 left-3 flex flex-col gap-1">
            @if($product->discount_price && $product->discount_price < $product->price)
                @php
                    $discountPct = round((($product->price - $product->discount_price) / $product->price) * 100);
                @endphp
                <span class="bg-rose-500 text-white text-[11px] font-black px-2 py-0.5 rounded-full shadow">
                    -{{ $discountPct }}%
                </span>
            @endif
            @if($product->is_featured)
                <span class="bg-amber-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow">
                    Featured
                </span>
            @endif
        </div>

        <!-- Wishlist Quick Action Button -->
        <form action="{{ route('wishlist.add') }}" method="POST" class="absolute top-3 right-3">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <button type="submit" class="w-8 h-8 rounded-full bg-white/90 hover:bg-white text-gray-600 hover:text-red-500 flex items-center justify-center shadow-md transition transform hover:scale-110" title="Add to Wishlist">
                <i class="fa-regular fa-heart text-sm"></i>
            </button>
        </form>
    </div>

    <!-- Product Details -->
    <div class="p-5 flex flex-col flex-grow">
        <!-- Brand & Category -->
        <div class="flex items-center justify-between text-[11px] text-gray-400 font-semibold uppercase tracking-wider mb-1">
            <a href="{{ route('products.brand', $product->brand->slug) }}" class="hover:text-blue-600 truncate max-w-[50%]">
                {{ $product->brand->name }}
            </a>
            <a href="{{ route('products.category', $product->category->slug) }}" class="hover:text-blue-600 truncate max-w-[50%] text-right">
                {{ $product->category->name }}
            </a>
        </div>

        <!-- Title -->
        <h3 class="text-sm font-bold text-gray-900 group-hover:text-blue-600 transition line-clamp-2 mb-2">
            <a href="{{ route('products.show', $product->slug) }}">
                {{ $product->name }}
            </a>
        </h3>

        <!-- Short Description -->
        <p class="text-xs text-gray-500 line-clamp-2 mb-4 flex-grow">
            {{ $product->short_description ?? Str::limit($product->description, 70) }}
        </p>

        <!-- Price & Cart Button -->
        <div class="pt-3 border-t border-gray-100 flex items-center justify-between mt-auto">
            <div>
                @if($product->discount_price && $product->discount_price < $product->price)
                    <div class="text-lg font-black text-rose-600">
                        ${{ number_format($product->discount_price, 2) }}
                    </div>
                    <div class="text-xs text-gray-400 line-through">
                        ${{ number_format($product->price, 2) }}
                    </div>
                @else
                    <div class="text-lg font-black text-gray-900">
                        ${{ number_format($product->price, 2) }}
                    </div>
                @endif
            </div>

            <!-- Quick Add to Cart Form -->
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white p-2.5 rounded-xl shadow hover:shadow-blue-500/30 transition transform hover:scale-105" title="Add to Cart">
                    <i class="fa-solid fa-cart-plus text-sm"></i>
                </button>
            </form>
        </div>
    </div>

</div>
