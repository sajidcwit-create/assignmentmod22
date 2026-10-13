<?php $__env->startSection('title', 'Home - ShopZone'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-12">

    <!-- 1. Hero Slider Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
        <div class="relative rounded-3xl overflow-hidden shadow-2xl bg-gray-900 aspect-[16/7] md:aspect-[21/8]">
            <?php if($sliders->isNotEmpty()): ?>
                <?php $firstSlider = $sliders->first(); ?>
                <img src="<?php echo e($firstSlider->image); ?>" alt="<?php echo e($firstSlider->title); ?>" class="w-full h-full object-cover opacity-75">
                <div class="absolute inset-0 bg-gradient-to-r from-gray-950 via-gray-900/70 to-transparent flex items-center">
                    <div class="max-w-xl px-8 sm:px-14 text-white space-y-4">
                        <span class="inline-block bg-blue-600 text-white text-xs uppercase font-extrabold px-3 py-1 rounded-full tracking-wider shadow">
                            Featured Deal
                        </span>
                        <h1 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight">
                            <?php echo e($firstSlider->title); ?>

                        </h1>
                        <p class="text-gray-300 text-sm sm:text-base line-clamp-2">
                            <?php echo e($firstSlider->short_description); ?>

                        </p>
                        <div class="pt-2 flex flex-wrap gap-3">
                            <a href="<?php echo e($firstSlider->link ?? route('products.index')); ?>" class="inline-flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full font-semibold text-sm shadow-lg hover:shadow-blue-500/30 transition transform hover:-translate-y-0.5">
                                <span>Shop Now</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                            <a href="<?php echo e(route('products.index')); ?>" class="inline-flex items-center space-x-2 bg-white/20 hover:bg-white/30 backdrop-blur text-white px-6 py-3 rounded-full font-semibold text-sm transition">
                                <span>Browse Catalog</span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- 2. Categories List Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-black text-gray-900">Shop by Category</h2>
                <p class="text-xs sm:text-sm text-gray-500">Pick from our handpicked curated categories</p>
            </div>
            <a href="<?php echo e(route('products.index')); ?>" class="text-blue-600 hover:text-blue-700 font-semibold text-sm flex items-center space-x-1">
                <span>View All</span>
                <i class="fa-solid fa-angle-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('products.category', $category->slug)); ?>" class="group bg-white rounded-2xl p-4 text-center border border-gray-100 hover:border-blue-300 hover:shadow-xl transition-all duration-200">
                    <div class="w-16 h-16 mx-auto mb-3 rounded-full overflow-hidden bg-gray-100 group-hover:scale-110 transition-transform">
                        <img src="<?php echo e($category->image ?? 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=300'); ?>" alt="<?php echo e($category->name); ?>" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-sm font-bold text-gray-800 group-hover:text-blue-600 transition"><?php echo e($category->name); ?></h3>
                    <p class="text-[11px] text-gray-400 mt-0.5"><?php echo e($category->products_count); ?> Products</p>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    <!-- 3. Featured Products Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <div class="inline-flex items-center space-x-1.5 text-blue-600 text-xs font-bold uppercase tracking-wider mb-1">
                    <i class="fa-solid fa-fire"></i>
                    <span>Top Picks</span>
                </div>
                <h2 class="text-2xl font-black text-gray-900">Featured Products</h2>
            </div>
            <a href="<?php echo e(route('products.index')); ?>" class="text-blue-600 hover:text-blue-700 font-semibold text-sm flex items-center space-x-1">
                <span>See More</span>
                <i class="fa-solid fa-angle-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('pages.products._card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    <!-- 4. Brands List Section -->
    <section class="bg-gradient-to-b from-gray-100 to-white py-12 border-y border-gray-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-xl mx-auto mb-8">
                <h2 class="text-2xl font-black text-gray-900">Official Brand Partners</h2>
                <p class="text-xs sm:text-sm text-gray-500">Shop certified genuine products from global market leaders</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
                <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('products.brand', $brand->slug)); ?>" class="flex flex-col items-center justify-center p-5 bg-white rounded-2xl border border-gray-200 hover:border-blue-500 hover:shadow-lg transition group">
                        <div class="w-14 h-14 rounded-full overflow-hidden bg-gray-50 mb-2 p-1 border group-hover:scale-105 transition">
                            <img src="<?php echo e($brand->image); ?>" alt="<?php echo e($brand->name); ?>" class="w-full h-full object-cover rounded-full">
                        </div>
                        <span class="text-sm font-bold text-gray-800 group-hover:text-blue-600"><?php echo e($brand->name); ?></span>
                        <span class="text-[11px] text-gray-400"><?php echo e($brand->products_count); ?> items</span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    <!-- 5. Latest Products Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <div class="inline-flex items-center space-x-1.5 text-emerald-600 text-xs font-bold uppercase tracking-wider mb-1">
                    <i class="fa-solid fa-sparkles"></i>
                    <span>Fresh In Stock</span>
                </div>
                <h2 class="text-2xl font-black text-gray-900">Latest Products</h2>
            </div>
            <a href="<?php echo e(route('products.index')); ?>" class="text-blue-600 hover:text-blue-700 font-semibold text-sm flex items-center space-x-1">
                <span>View Full Catalog</span>
                <i class="fa-solid fa-angle-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php $__currentLoopData = $latestProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('pages.products._card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SAJID CWIT\Desktop\Assignment\resources\views/pages/home.blade.php ENDPATH**/ ?>