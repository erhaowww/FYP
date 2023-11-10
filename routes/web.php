<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;

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
Route::get('product', function () {
    return view('user/product');
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

// user
Route::prefix('user')->middleware(['auth'])->group(function(){
    Route::get('/edit-profile', [UserController::class, 'edit_profile'])->name('profile');
    Route::post('/submitEditProfileForm/{id}', [UserController::class, 'submitEditProfileForm'])->name('submitEditProfileForm');
    Route::get('/sendOTP/{phoneNumber}', [UserController::class, 'sendOTP']);
    Route::get('/validateOTP/{otp}', [UserController::class, 'validateOTP']);
});


// admin
Route::prefix('admin')->middleware(['auth'])->group(function(){
    Route::resource('customers', UserController::class);
});


