<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function  () {
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
});
