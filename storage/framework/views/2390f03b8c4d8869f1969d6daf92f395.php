<?php $__env->startSection('title', 'All Products - ShopZone'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <nav class="flex text-xs text-gray-500 mb-2 space-x-2">
            <a href="<?php echo e(route('home')); ?>" class="hover:text-blue-600">Home</a>
            <span>/</span>
            <span class="text-gray-800 font-semibold">
                <?php if(isset($currentCategory)): ?>
                    Category: <?php echo e($currentCategory->name); ?>

                <?php elseif(isset($currentBrand)): ?>
                    Brand: <?php echo e($currentBrand->name); ?>

                <?php elseif(request('search')): ?>
                    Search: "<?php echo e(request('search')); ?>"
                <?php else: ?>
                    All Products
                <?php endif; ?>
            </span>
        </nav>
        <h1 class="text-3xl font-black text-gray-900">
            <?php if(isset($currentCategory)): ?>
                <?php echo e($currentCategory->name); ?> Products
            <?php elseif(isset($currentBrand)): ?>
                <?php echo e($currentBrand->name); ?> Collection
            <?php elseif(request('search')): ?>
                Search results for "<?php echo e(request('search')); ?>"
            <?php else: ?>
                Discover Products
            <?php endif; ?>
        </h1>
        <p class="text-sm text-gray-500 mt-1">Found <?php echo e($products->total()); ?> items matching your criteria</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Filters Sidebar -->
        <aside class="space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-6">
                <div class="flex items-center justify-between border-b pb-3">
                    <h3 class="font-bold text-gray-900">Filters</h3>
                    <a href="<?php echo e(route('products.index')); ?>" class="text-xs text-blue-600 hover:underline">Reset All</a>
                </div>

                <!-- Categories Filter -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">Categories</h4>
                    <ul class="space-y-2 text-sm">
                        <li>
                            <a href="<?php echo e(route('products.index')); ?>" class="flex items-center justify-between <?php echo e(!request('category') && !isset($currentCategory) ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-600'); ?>">
                                <span>All Categories</span>
                            </a>
                        </li>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a href="<?php echo e(route('products.category', $cat->slug)); ?>" class="flex items-center justify-between <?php echo e((isset($currentCategory) && $currentCategory->id === $cat->id) || request('category') == $cat->slug ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-600'); ?>">
                                    <span><?php echo e($cat->name); ?></span>
                                    <span class="text-xs text-gray-400">(<?php echo e($cat->products_count); ?>)</span>
                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>

                <!-- Brands Filter -->
                <div class="border-t pt-4">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">Brands</h4>
                    <ul class="space-y-2 text-sm">
                        <li>
                            <a href="<?php echo e(route('products.index')); ?>" class="flex items-center justify-between <?php echo e(!request('brand') && !isset($currentBrand) ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-600'); ?>">
                                <span>All Brands</span>
                            </a>
                        </li>
                        <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a href="<?php echo e(route('products.brand', $b->slug)); ?>" class="flex items-center justify-between <?php echo e((isset($currentBrand) && $currentBrand->id === $b->id) || request('brand') == $b->slug ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-600'); ?>">
                                    <span><?php echo e($b->name); ?></span>
                                    <span class="text-xs text-gray-400">(<?php echo e($b->products_count); ?>)</span>
                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>

                <!-- Sort Filter -->
                <div class="border-t pt-4">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">Sort By</h4>
                    <form action="<?php echo e(url()->current()); ?>" method="GET" class="space-y-2">
                        <?php if(request('search')): ?> <input type="hidden" name="search" value="<?php echo e(request('search')); ?>"> <?php endif; ?>
                        <?php if(request('category')): ?> <input type="hidden" name="category" value="<?php echo e(request('category')); ?>"> <?php endif; ?>
                        <?php if(request('brand')): ?> <input type="hidden" name="brand" value="<?php echo e(request('brand')); ?>"> <?php endif; ?>
                        <select name="sort" onchange="this.form.submit()" class="w-full text-sm border-gray-300 rounded-xl bg-gray-50 p-2.5 focus:border-blue-500 focus:bg-white focus:outline-none">
                            <option value="newest" <?php echo e(request('sort') == 'newest' ? 'selected' : ''); ?>>Newest Arrivals</option>
                            <option value="price_low" <?php echo e(request('sort') == 'price_low' ? 'selected' : ''); ?>>Price: Low to High</option>
                            <option value="price_high" <?php echo e(request('sort') == 'price_high' ? 'selected' : ''); ?>>Price: High to Low</option>
                        </select>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Product Grid & Pagination -->
        <main class="lg:col-span-3 space-y-6">
            <?php if($products->isEmpty()): ?>
                <div class="bg-white rounded-2xl p-12 text-center border border-gray-200">
                    <div class="w-16 h-16 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">No products found</h3>
                    <p class="text-sm text-gray-500 mb-6">We couldn't find any products matching your selected criteria.</p>
                    <a href="<?php echo e(route('products.index')); ?>" class="inline-flex items-center space-x-2 bg-blue-600 text-white text-sm font-semibold px-5 py-2.5 rounded-full shadow hover:bg-blue-700 transition">
                        <span>Clear Filters</span>
                    </a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('pages.products._card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    <?php echo e($products->links()); ?>

                </div>
            <?php endif; ?>
        </main>

    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SAJID CWIT\Desktop\Assignment\resources\views/pages/products/index.blade.php ENDPATH**/ ?>