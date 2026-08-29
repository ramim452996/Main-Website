<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Main Single Page Food Delivery Interface
Route::get('/', [FoodController::class, 'index'])->name('home');

// Admin Panel Dashboard & APIs
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/dashboard', [AdminController::class, 'index']);
Route::get('/api/admin/stats', [AdminController::class, 'getStats']);
Route::get('/api/admin/orders', [AdminController::class, 'getOrders']);
Route::post('/api/admin/orders/{id}/status', [AdminController::class, 'updateOrderStatus']);
Route::get('/api/admin/customers', [AdminController::class, 'getCustomers']);

// Orders Pages
Route::get('/order', [OrderController::class, 'orderPage'])->name('order.page');
Route::get('/orders-bn', [OrderController::class, 'orderPageBn'])->name('order.bn');
Route::get('/order-bn', [OrderController::class, 'orderPageBn']);

// Standalone Auth Pages
Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup.page');
Route::get('/register', function () {
    return view('auth.signup');
});
Route::get('/login', function () {
    return view('auth.login');
})->name('login.page');

// Contact Us Pages
Route::get('/contact-us', function () {
    return view('contact');
})->name('contact.page');

Route::get('/contact-bn', function () {
    return view('contact_bn');
})->name('contact.bn');
Route::get('/jogajog', function () {
    return view('contact_bn');
});

// Authentication Endpoints
Route::post('/api/auth/register', [AuthController::class, 'register'])->name('api.auth.register');
Route::post('/api/auth/login', [AuthController::class, 'login'])->name('api.auth.login');
Route::post('/api/auth/logout', [AuthController::class, 'logout'])->name('api.auth.logout');
Route::get('/api/auth/me', [AuthController::class, 'me'])->name('api.auth.me');

// Contact Form Submission API
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
