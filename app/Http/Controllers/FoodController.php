<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FoodItem;
use App\Models\PromoCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FoodController extends Controller
{
    /**
     * Display the single page food delivery home.
     */
    public function index(): View
    {
        $categories = Category::withCount('foodItems')
            ->orderBy('display_order')
            ->get();

        $featuredItems = FoodItem::with('category')
            ->where('is_featured', true)
            ->take(6)
            ->get();

        $chefSpecials = FoodItem::with('category')
            ->where('is_chef_special', true)
            ->take(4)
            ->get();

        $promoCodes = PromoCode::where('is_active', true)->get();

        $allFoodItems = FoodItem::with('category')
            ->orderBy('is_featured', 'desc')
            ->get();

        return view('welcome', compact('categories', 'featuredItems', 'chefSpecials', 'promoCodes', 'allFoodItems'));
    }

    /**
     * API: Filter and search food catalog.
     */
    public function getItems(Request $request): JsonResponse
    {
        $query = FoodItem::with('category');

        // Filter by category slug
        if ($request->filled('category') && $request->category !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search by query
        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                  ->orWhere('description', 'like', $search);
            });
        }

        // Dietary filters
        if ($request->boolean('vegetarian')) {
            $query->where('is_vegetarian', true);
        }

        if ($request->boolean('spicy')) {
            $query->where('is_spicy', true);
        }

        if ($request->boolean('chef_special')) {
            $query->where('is_chef_special', true);
        }

        if ($request->boolean('under_15')) {
            $query->where('price', '<=', 15.00);
        }

        // Sorting
        $sort = $request->get('sort', 'popular');
        match ($sort) {
            'rating' => $query->orderBy('rating', 'desc'),
            'price_low' => $query->orderBy('price', 'asc'),
            'price_high' => $query->orderBy('price', 'desc'),
            'prep_time' => $query->orderBy('prep_time', 'asc'),
            default => $query->orderBy('is_popular', 'desc')->orderBy('rating', 'desc'),
        };

        $items = $query->get();

        return response()->json([
            'status' => 'success',
            'count' => $items->count(),
            'data' => $items,
        ]);
    }

    /**
     * API: Validate Promo / Coupon Code.
     */
    public function validateCoupon(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required|string',
            'subtotal' => 'required|numeric|min:0',
            'delivery_fee' => 'nullable|numeric|min:0',
        ]);

        $code = strtoupper(trim($request->code));
        $subtotal = (float) $request->subtotal;
        $deliveryFee = (float) ($request->delivery_fee ?? 3.99);

        $promo = PromoCode::where('code', $code)->first();

        if (!$promo) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid promo code. Try TASTY30 or FREEDEL.',
            ], 422);
        }

        $result = $promo->calculateDiscount($subtotal, $deliveryFee);

        return response()->json($result, $result['valid'] ? 200 : 422);
    }
}
