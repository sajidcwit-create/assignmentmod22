<?php $__env->startSection('title', 'Login with OTP - ShopZone'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-md mx-auto px-4 py-16">
    <div class="bg-white rounded-3xl border border-gray-200 shadow-xl p-8 sm:p-10 space-y-8">
        
        <!-- Header -->
        <div class="text-center space-y-2">
            <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto text-2xl shadow-inner">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h1 class="text-2xl font-black text-gray-900">OTP-Based Authentication</h1>
            <p class="text-xs text-gray-500">Fast, secure, passwordless login via One-Time Passcode</p>
        </div>

        <!-- Quick Demo Account Helper -->
        <div class="bg-blue-50/70 border border-blue-200/60 rounded-2xl p-4 text-xs text-blue-900 space-y-1">
            <p class="font-bold flex items-center"><i class="fa-solid fa-lightbulb text-amber-500 mr-1.5"></i> Quick Demo Tip:</p>
            <p>You can use <span class="font-mono bg-blue-100 px-1 py-0.5 rounded font-bold cursor-pointer" onclick="document.getElementById('email').value='user@example.com'">user@example.com</span> or enter any valid email address to test.</p>
        </div>

        <!-- Form: Step 1 Send OTP -->
        <form action="<?php echo e(route('login.otp.send')); ?>" method="POST" class="space-y-5">
            <?php echo csrf_field(); ?>
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                    <input type="email" name="email" id="email" required autofocus
                        value="<?php echo e(old('email', 'user@example.com')); ?>" 
                        placeholder="e.g. user@example.com"
                        class="w-full bg-gray-50 border border-gray-300 rounded-xl pl-10 pr-4 py-3 text-sm text-gray-900 focus:bg-white focus:border-blue-500 focus:outline-none transition">
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-md hover:shadow-blue-500/30 transition flex items-center justify-center space-x-2">
                <span>Send One-Time Password (OTP)</span>
                <i class="fa-solid fa-paper-plane text-xs"></i>
            </button>
        </form>

        <div class="text-center pt-2 border-t border-gray-100 text-xs text-gray-400">
            Protected by Laravel Sanctum & SSLCommerz Ready
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SAJID CWIT\Desktop\Assignment\resources\views/pages/auth/login.blade.php ENDPATH**/ ?>