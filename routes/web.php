<?php

use App\Http\Controllers\FoodController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Main Single Page Food Delivery Interface
Route::get('/', [FoodController::class, 'index'])->name('home');
Route::get('/order', [OrderController::class, 'orderPage'])->name('order.page');
Route::get('/contact-us', function () {
    return view('contact');
})->name('contact.page');

// Contact Form Submission
Route::post('/api/contact/submit', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:100',
        'phone' => 'required|string|max:20',
        'subject' => 'required|string|max:150',
        'message' => 'required|string|max:1000',
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'ধন্যবাদ ' . $validated['name'] . '! আপনার বার্তাটি কুষ্টিয়া এক্সপ্রেস হেল্পডেস্কে পৌঁছেছে। শীঘ্রই আমাদের কাস্টমার প্রতিনিধি যোগাযোগ করবেন।'
    ]);
})->name('api.contact.submit');
