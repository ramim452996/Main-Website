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
     * Create and store a new food order.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:100',
            'delivery_address' => 'required|string|max:255',
            'notes' => 'nullable|string|max:500',
            'payment_method' => 'required|string|in:card,cash,apple_pay',
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

        $deliveryFee = $subtotal >= 35.00 ? 0.00 : 3.99;
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

        $tax = round(($subtotal - $discount) * 0.08, 2); // 8% sales tax
        $tax = max(0, $tax);
        $tip = (float) ($validated['tip'] ?? 0);
        $total = max(0, round($subtotal - $discount + $deliveryFee + $tax + $tip, 2));

        $orderCode = 'FD-' . strtoupper(Str::random(6));

        $order = Order::create([
            'order_code' => $orderCode,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_email' => $validated['customer_email'],
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
            'message' => 'Order placed successfully!',
            'order' => $order,
        ]);
    }

    /**
     * API: Live order tracking endpoint.
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

        // Calculate simulated dynamic delivery progression based on created_at time
        $minutesAgo = Carbon::now()->diffInMinutes($order->created_at);

        $status = 'received';
        $progress = 25;
        $driverName = 'Alex Rodriguez';
        $driverPhone = '+1 (555) 234-5678';
        $driverVehicle = 'Eco-Electric Vespa (Plate: NY-782)';

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
                    'rating' => 4.95,
                    'photo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80',
                ],
                'estimated_minutes_left' => max(1, 25 - $minutesAgo),
                'steps' => [
                    ['title' => 'Order Received', 'description' => 'Restaurant confirmed your order', 'done' => true, 'time' => $order->created_at->format('h:i A')],
                    ['title' => 'In the Kitchen', 'description' => 'Master Chef preparing your meal fresh', 'done' => $progress >= 50, 'time' => $order->created_at->addMinutes(3)->format('h:i A')],
                    ['title' => 'On the Way', 'description' => 'Driver en route with thermal insulated bag', 'done' => $progress >= 75, 'time' => $order->created_at->addMinutes(12)->format('h:i A')],
                    ['title' => 'Delivered', 'description' => 'Handed over at your doorstep', 'done' => $progress >= 100, 'time' => $order->created_at->addMinutes(25)->format('h:i A')],
                ]
            ]
        ]);
    }
}
