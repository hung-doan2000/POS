<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('brands')->group(function(){
    Route::get('', [BrandController::class, 'indexBrand']);
    //Route::get('show/{id}', [BrandController::class, 'show']);
    Route::get('/edit/{id}', [BrandController::class, 'editBrand']);
    Route::post('store',[BrandController::class,'storeBrand']);
    Route::put('update/{id}',[BrandController::class,'updateBrand']);
    Route::delete('delete/{id}',[BrandController::class,'deleteBrand']);
});
Route::prefix('pos')->group(function(){
    Route::get('/index', [OrderController::class, 'indexPos']);
    //Route::get('show/{id}', [BrandController::class, 'show']);
    // Route::get('/edit/{id}', [BrandController::class, 'editBrand']);
    // Route::post('store',[BrandController::class,'storeBrand']);
    // Route::put('update/{id}',[BrandController::class,'updateBrand']);
    // Route::delete('delete/{id}',[BrandController::class,'deleteBrand']);
});
