<?php

use App\Http\Controllers\FoodController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Main Single Page Food Delivery Interface
Route::get('/', [FoodController::class, 'index'])->name('home');

// Interactive SPA Endpoints
Route::prefix('api')->group(function () {
    Route::get('/food-items', [FoodController::class, 'getItems'])->name('api.food.items');
    Route::post('/validate-coupon', [FoodController::class, 'validateCoupon'])->name('api.coupon.validate');
    Route::post('/orders', [OrderController::class, 'store'])->name('api.orders.store');
    Route::get('/orders/{code}/track', [OrderController::class, 'track'])->name('api.orders.track');
});
