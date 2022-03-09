<?php

use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\FeedController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialiteAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RssController;

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

Route::get('orders/{any}', function () {
    return view('pos');
  })->where('any', '.*');



Route::get('/fbfeed.xml/{id}', [FeedController::class, 'fbFeed'])->name('fbfeed');
Route::get('/ggfeed.xml/{id}', [FeedController::class, 'ggFeed'])->name('ggFeed');

Route::get('google', [CustomerController::class, 'googleRedirect'])->name('auth.google');
Route::get('/auth/google-callback', [CustomerController::class, 'loginWithGoogle']);
//Route::get('facebook', [CustomerController::class, 'facebookRedirect'])->name('auth.facebook');
//Route::get('/auth/facebook/callback', [CustomerController::class, 'loginWithFacebook']);

Route::get('admin/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('forgot.password.get');
Route::post('admin/forgot-password', [ForgotPasswordController::class, 'submitForgotPasswordForm'])->name('forgot.password.post');
Route::get('admin/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('admin/reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');


