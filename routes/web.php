<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartItemController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('user/index');
});
Route::get('/auth/google', [UserController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [UserController::class, 'handleGoogleCallback']);
Route::get('logout', function () {
    session()->flush();
    return redirect('/');
});
Route::get('/forget_password', function () {
    return view('user/forgetPassword');
});
Route::post('/forget_password', [UserController::class, 'forgetPassword']);
Route::post('/submitResetPasswordForm', [UserController::class, 'submitResetPasswordForm']);
Route::get('user/reset_password/{token}/{email}', [UserController::class, 'verify_reset_password'])->name('reset_password');

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::get('/product', [ProductController::class, 'show'])->name('products.show');
Route::get('/product/{id}', [ProductController::class, 'showDetail'])->name('product.detail');

// user
Route::prefix('user')->middleware(['auth'])->group(function(){
    Route::get('/edit-profile', [UserController::class, 'edit_profile'])->name('profile');
    Route::post('/submitEditProfileForm/{id}', [UserController::class, 'submitEditProfileForm'])->name('submitEditProfileForm');
    Route::get('/sendOTP/{phoneNumber}', [UserController::class, 'sendOTP']);
    Route::get('/validateOTP/{otp}', [UserController::class, 'validateOTP']);
    Route::post('/add-to-cart', [CartItemController::class, 'addToCart']);
    Route::post('/remove-from-cart', [CartItemController::class, 'removeItem']);
    Route::get('/cart', [CartItemController::class, 'showCart']);
    Route::post('/update-cart-item', [CartItemController::class, 'updateItem']);

});


// admin
Route::prefix('admin')->middleware(['auth'])->group(function(){
    Route::resource('customers', UserController::class);
});