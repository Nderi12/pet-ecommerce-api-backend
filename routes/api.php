<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Admin routes
Route::group(['prefix' => 'v1/admin'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/reset-password-token', [AuthController::class, 'resetPassword']);

    // Users endpoints/apis
    Route::get('user-listing', [UserController::class, 'index']);
    Route::put('user-edit/{uuid}', [UserController::class, 'update']);
    Route::delete('user-delete/{uuid}', [UserController::class, 'destroy']);
});

// Main routes
Route::group(['prefix' => 'v1/main'], function () {
    // Blog endpoints/apis
    Route::get('blogs', [BlogController::class, 'index']);
    Route::post('blog/create', [BlogController::class, 'store']);
    Route::get('blog/{uuid}', [BlogController::class, 'show']);
    Route::put('blog/{uuid}', [BlogController::class, 'update']);
    Route::delete('blog/{uuid}', [BlogController::class, 'destroy']);

    // Promotion endpoints/apis
    Route::get('promotions', [PromotionController::class, 'index']);
    Route::post('promotion/create', [PromotionController::class, 'store']);
    Route::get('promotion/{uuid}', [PromotionController::class, 'show']);
    Route::put('promotion/{uuid}', [PromotionController::class, 'update']);
    Route::delete('promotion/{uuid}', [PromotionController::class, 'destroy']);
});

Route::group(['middleware' => 'jwt', 'prefix' => 'v1'], function () {
    // Category endpoints/apis
    Route::get('categories', [CategoryController::class, 'index']);
    Route::post('category/create', [CategoryController::class, 'store']);
    Route::get('category/{uuid}', [CategoryController::class, 'show']);
    Route::put('category/{uuid}', [CategoryController::class, 'update']);
    Route::delete('category/{uuid}', [CategoryController::class, 'destroy']);

    // Products endpoints/apis
    Route::get('products', [ProductController::class, 'index']);
    Route::post('product/create', [ProductController::class, 'store']);
    Route::get('product/{uuid}', [ProductController::class, 'show']);
    Route::put('product/{uuid}', [ProductController::class, 'update']);
    Route::delete('product/{uuid}', [ProductController::class, 'destroy']);

    // Order status endpoints/apis
    Route::get('order-statuses', [OrderStatusController::class, 'index']);
    Route::post('order-status/create', [OrderStatusController::class, 'store']);
    Route::get('order-status/{uuid}', [OrderStatusController::class, 'show']);
    Route::put('order-status/{uuid}', [OrderStatusController::class, 'update']);
    Route::delete('order-status/{uuid}', [OrderStatusController::class, 'destroy']);

    // Brand endpoints/apis
    Route::get('brands', [BrandController::class, 'index']);
    Route::post('brand/create', [BrandController::class, 'store']);
    Route::get('brand/{uuid}', [BrandController::class, 'show']);
    Route::put('brand/{uuid}', [BrandController::class, 'update']);
    Route::delete('brand/{uuid}', [BrandController::class, 'destroy']);
});
