<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PromoCode;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display dedicated Orders & Live Tracking page.
     */
    public function orderPage(Request $request): \Illuminate\View\View
    {
        $orderCode = $request->query('code');
        $initialOrder = null;
        if ($orderCode) {
            $initialOrder = Order::where('order_code', strtoupper($orderCode))->first();
        }

        $recentOrders = Order::latest()->take(5)->get();

        return view('order', compact('initialOrder', 'recentOrders'));
    }

    /**
     * Display dedicated Orders & Live Tracking page in Bengali.
     */
    public function orderPageBn(Request $request): \Illuminate\View\View
    {
        $orderCode = $request->query('code');
        $initialOrder = null;
        if ($orderCode) {
            $initialOrder = Order::where('order_code', strtoupper($orderCode))->first();
        }

        $recentOrders = Order::latest()->take(5)->get();

        return view('order_bn', compact('initialOrder', 'recentOrders'));
    }

    /**
     * Create and store a new food order for Kushtia, Bangladesh.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:100',
            'delivery_address' => 'required|string|max:255',
            'notes' => 'nullable|string|max:500',
            'payment_method' => 'required|string|in:bkash,nagad,rocket,cash',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.selected_size' => 'nullable|string',
            'items.*.selected_toppings' => 'nullable|array',
            'promo_code' => 'nullable|string',
            'tip' => 'nullable|numeric|min:0',
        ]);

        $subtotal = 0;
        foreach ($validated['items'] as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $subtotal += $itemTotal;
        }

        // Delivery fee in Kushtia: ৳40 (Free on ৳400+)
        $deliveryFee = $subtotal >= 400.00 ? 0.00 : 40.00;
        $discount = 0.00;

        if (!empty($validated['promo_code'])) {
            $promo = PromoCode::where('code', strtoupper($validated['promo_code']))->first();
            if ($promo) {
                $calc = $promo->calculateDiscount($subtotal, $deliveryFee);
                if ($calc['valid']) {
                    $discount = $calc['discount'];
                }
            }
        }

        $tax = round(($subtotal - $discount) * 0.05, 2); // 5% VAT in BD
        $tax = max(0, $tax);
        $tip = (float) ($validated['tip'] ?? 0);
        $total = max(0, round($subtotal - $discount + $deliveryFee + $tax + $tip, 2));

        $orderCode = 'KUS-' . strtoupper(Str::random(6));

        $order = Order::create([
            'order_code' => $orderCode,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_email' => $validated['customer_email'] ?? 'customer@kushtia.com',
            'delivery_address' => $validated['delivery_address'],
            'notes' => $validated['notes'] ?? null,
            'payment_method' => $validated['payment_method'],
            'status' => 'received',
            'subtotal' => round($subtotal, 2),
            'discount' => round($discount, 2),
            'delivery_fee' => round($deliveryFee, 2),
            'tax' => round($tax, 2),
            'tip' => round($tip, 2),
            'total' => round($total, 2),
            'promo_code' => $validated['promo_code'] ?? null,
            'items' => $validated['items'],
            'estimated_delivery_at' => Carbon::now()->addMinutes(25),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'কুষ্টিয়া এক্সপ্রেস এ আপনার অর্ডারটি সফলভাবে গৃহীত হয়েছে!',
            'order' => $order,
        ]);
    }

    /**
     * API: Live order tracking endpoint for Kushtia town.
     */
    public function track(string $orderCode): JsonResponse
    {
        $order = Order::where('order_code', $orderCode)->first();

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
            ], 404);
        }

        $minutesAgo = Carbon::now()->diffInMinutes($order->created_at);

        $status = 'received';
        $progress = 25;
        $driverName = 'Md. Tanvir Hossain (তানভীর)';
        $driverPhone = '+880 1712-345678';
        $driverVehicle = 'Hero Hunk 150R (কুষ্টিয়া-হ-১১-৮৭৬৫)';

        if ($minutesAgo >= 15) {
            $status = 'delivered';
            $progress = 100;
        } elseif ($minutesAgo >= 7) {
            $status = 'on_the_way';
            $progress = 75;
        } elseif ($minutesAgo >= 2) {
            $status = 'preparing';
            $progress = 50;
        }

        return response()->json([
            'status' => 'success',
            'order' => $order,
            'tracking' => [
                'current_stage' => $status,
                'progress_percentage' => $progress,
                'driver' => [
                    'name' => $driverName,
                    'phone' => $driverPhone,
                    'vehicle' => $driverVehicle,
                    'rating' => 4.96,
                    'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80',
                ],
                'estimated_minutes_left' => max(1, 25 - $minutesAgo),
                'steps' => [
                    ['title' => 'অর্ডার গৃহীত হয়েছে (Order Received)', 'description' => 'রেস্টুরেন্টে আপনার অর্ডারটি গৃহীত হয়েছে', 'done' => true, 'time' => $order->created_at->format('h:i A')],
                    ['title' => 'রান্না চলছে (Kitchen Preparing)', 'description' => 'শেফ আপনার খাবারটি টাটকা প্রস্তুত করছেন', 'done' => $progress >= 50, 'time' => $order->created_at->addMinutes(3)->format('h:i A')],
                    ['title' => 'রাইডার পথে আছে (Rider On the Way)', 'description' => 'গরম ও নিরাপদ প্যাকেজিংয়ে রাইডার কুষ্টিয়ার রাস্তায় রয়েছে', 'done' => $progress >= 75, 'time' => $order->created_at->addMinutes(12)->format('h:i A')],
                    ['title' => 'ডেলিভারি সম্পন্ন (Delivered)', 'description' => 'আপনার ঠিকানায় খাবার পৌঁছে দেওয়া হয়েছে', 'done' => $progress >= 100, 'time' => $order->created_at->addMinutes(25)->format('h:i A')],
                ]
            ]
        ]);
    }
}
