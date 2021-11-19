<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ConfirmationController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\SaveForLaterController;
use App\Http\Controllers\ShopController;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [IndexController::class,'index'])->name('index');
Route::get('/shop', [ShopController::class,'index'])->name('shop');
Route::get('/shop/{product}', [ShopController::class,'show'])->name('shop.show');

Route::get('/cart', [CartController::class,'index'])->name('cart');
Route::post('/cart', [CartController::class,'store'])->name('cart.store');
Route::patch('/cart/{product}', [CartController::class,'update'])->name('cart.update');
Route::delete('/cart/{product}', [CartController::class,'destroy'])->name('cart.destroy');
Route::post('/cart/switchToSaveForLater/{product}', [CartController::class,'switchToSaveForLater'])->name('cart.switchToSaveForLater');

Route::delete('/saveForLater/{product}', [SaveForLaterController::class,'destroy'])->name('saveforlater.destroy');
Route::post('/saveForLater/switchToCart/{product}', [SaveForLaterController::class,'switchToCart'])->name('saveforlater.switchToCart');

Route::get('/checkout', [CheckoutController::class,'index'])->name('checkout')->middleware('auth');
Route::post('/checkout', [CheckoutController::class,'store'])->name('checkout.store');

Route::get('/guest-checkout', [CheckoutController::class,'index'])->name('guestCheckout');

Route::post('/coupon', [CouponController::class,'store'])->name('coupon.store');
Route::delete('/coupon', [CouponController::class,'destroy'])->name('coupon.destroy');


Route::get('/thankyou', [ConfirmationController::class,'index'])->name('thankyou');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
