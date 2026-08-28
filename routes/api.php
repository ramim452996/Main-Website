<?php

use App\Http\Controllers\FoodController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/food-items', [FoodController::class, 'getItems'])->name('api.food.items');
Route::post('/validate-coupon', [FoodController::class, 'validateCoupon'])->name('api.coupon.validate');
Route::post('/orders', [OrderController::class, 'store'])->name('api.orders.store');
Route::get('/orders/{code}/track', [OrderController::class, 'track'])->name('api.orders.track');
