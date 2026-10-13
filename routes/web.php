<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (Laravel Blade Frontend)
|--------------------------------------------------------------------------
*/

// 1. Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// 2. Product Module
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/category/{slug}', [ProductController::class, 'byCategory'])->name('products.category');
Route::get('/brand/{slug}', [ProductController::class, 'byBrand'])->name('products.brand');

// 3. User Authentication (OTP-based)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login/otp/send', [AuthController::class, 'sendOtp'])->name('login.otp.send');
Route::get('/login/verify', [AuthController::class, 'showVerifyOtp'])->name('login.verify.view');
Route::post('/login/otp/verify', [AuthController::class, 'verifyOtp'])->name('login.otp.verify');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    // 4. Shopping Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // 5. Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');

    // 6. Checkout & SSLCommerz
    Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout.index');
    Route::post('/checkout/pay', [CheckoutController::class, 'initiatePayment'])->name('checkout.initiate');
    Route::get('/checkout/sslcommerz/{transaction_id}', [CheckoutController::class, 'sslcommerzGateway'])->name('checkout.sslcommerz');
    Route::post('/checkout/sslcommerz/success', [CheckoutController::class, 'paymentSuccess'])->name('sslcommerz.success');
    Route::post('/checkout/sslcommerz/fail', [CheckoutController::class, 'paymentFail'])->name('sslcommerz.fail');
    Route::post('/checkout/sslcommerz/cancel', [CheckoutController::class, 'paymentCancel'])->name('sslcommerz.cancel');

    // 7. Order History
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
});
