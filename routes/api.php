<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
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


Route::post('login', [AuthController::class, 'login']);



Route::middleware('auth:sanctum')->group(function () {
    Route::post('product/create/step_1', [ProductController::class, 'create_step1']);
    Route::post('product/create/step_2', [ProductController::class, 'create_step2']);
    Route::post('product/create/step_3', [ProductController::class, 'create_step3']);
    Route::put('product/update_step1/{id}', [ProductController::class, 'update_step1']);
    Route::put('product/update_step2/{id}', [ProductController::class, 'update_step2']);
    Route::put('product/update_step3/{id}', [ProductController::class, 'update_step3']);
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/count', [ProductController::class, 'count']);
    Route::get('products/edit/{id}', [ProductController::class, 'edit']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    Route::delete('products/{id}', [ProductController::class, 'deleteProduct']);
    Route::get('products/count', [ProductController::class, 'count']);
});


