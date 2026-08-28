<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register a new customer.
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:150|unique:users,email',
            'phone' => 'required|string|max:20|unique:users,phone',
            'delivery_zone' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|min:6',
        ], [
            'email.unique' => 'এই ইমেইল দিয়ে ইতোমধ্যে একটি অ্যাকাউন্ট রয়েছে। (Email already registered)',
            'phone.unique' => 'এই মোবাইল নম্বর দিয়ে ইতোমধ্যে একটি অ্যাকাউন্ট রয়েছে। (Phone already registered)',
            'password.min' => 'পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে। (Password must be at least 6 characters)',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => strtolower($validated['email']),
            'phone' => $validated['phone'],
            'delivery_zone' => $validated['delivery_zone'] ?? 'মজমুপুর গেট ও এনএস রোড',
            'address' => $validated['address'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user, true);

        return response()->json([
            'status' => 'success',
            'message' => 'স্বাগতম, ' . $user->name . '! আপনার অ্যাকাউন্ট সফলভাবে তৈরি হয়েছে।',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'delivery_zone' => $user->delivery_zone,
                'address' => $user->address,
            ]
        ], 201);
    }

    /**
     * Authenticate customer (supports Login via Email or Phone).
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'login_id' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginId = $credentials['login_id'];
        $fieldType = filter_var($loginId, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $attempt = Auth::attempt([
            $fieldType => $loginId,
            'password' => $credentials['password'],
        ], $request->boolean('remember', true));

        if (!$attempt) {
            return response()->json([
                'status' => 'error',
                'message' => 'ভুল মোবাইল/ইমেইল অথবা পাসওয়ার্ড। অনুগ্রহ করে আবার চেষ্টা করুন।',
            ], 422);
        }

        /** @var User $user */
        $user = Auth::user();

        return response()->json([
            'status' => 'success',
            'message' => 'লগইন সফল হয়েছে! স্বাগতম ' . $user->name . '।',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'delivery_zone' => $user->delivery_zone,
                'address' => $user->address,
            ]
        ]);
    }

    /**
     * Log the customer out.
     */
    public function logout(Request $request): JsonResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'status' => 'success',
            'message' => 'আপনি সফলভাবে লগআউট করেছেন।'
        ]);
    }

    /**
     * Get current authenticated customer.
     */
    public function me(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'logged_in' => false,
                'user' => null,
            ]);
        }

        /** @var User $user */
        $user = Auth::user();

        return response()->json([
            'logged_in' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'delivery_zone' => $user->delivery_zone,
                'address' => $user->address,
            ]
        ]);
    }
}
