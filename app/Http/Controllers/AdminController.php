<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\FoodItem;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display the Admin Dashboard view.
     */
    public function index(): View
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total');
        $totalCustomers = User::count();
        $activeOrders = Order::whereIn('status', ['received', 'preparing', 'on_the_way'])->count();
        $totalMenuItems = FoodItem::count();

        $recentOrders = Order::latest()->take(10)->get();
        $customers = User::latest()->take(15)->get();
        $menuItems = FoodItem::with('category')->get();
        $messages = class_exists(ContactMessage::class) ? ContactMessage::latest()->take(10)->get() : collect([]);

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'totalCustomers',
            'activeOrders',
            'totalMenuItems',
            'recentOrders',
            'customers',
            'menuItems',
            'messages'
        ));
    }

    /**
     * API: Get comprehensive admin statistics.
     */
    public function getStats(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'stats' => [
                'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total'),
                'total_orders' => Order::count(),
                'active_orders' => Order::whereIn('status', ['received', 'preparing', 'on_the_way'])->count(),
                'delivered_orders' => Order::where('status', 'delivered')->count(),
                'total_customers' => User::count(),
                'total_menu_items' => FoodItem::count(),
            ],
            'recent_orders' => Order::latest()->take(20)->get(),
            'customers' => User::latest()->take(20)->get(),
        ]);
    }

    /**
     * API: Update Order Status (received -> preparing -> on_the_way -> delivered -> cancelled).
     */
    public function updateOrderStatus(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|string|in:received,preparing,on_the_way,delivered,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $validated['status'];
        $order->save();

        return response()->json([
            'status' => 'success',
            'message' => "Order #{$order->order_code} status updated to '{$order->status}' successfully!",
            'order' => $order,
        ]);
    }

    /**
     * API: List all orders with search & status filter.
     */
    public function getOrders(Request $request): JsonResponse
    {
        $query = Order::latest();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', $search)
                  ->orWhere('customer_name', 'like', $search)
                  ->orWhere('customer_phone', 'like', $search);
            });
        }

        $orders = $query->paginate(25);

        return response()->json([
            'status' => 'success',
            'data' => $orders,
        ]);
    }

    /**
     * API: List all registered customers.
     */
    public function getCustomers(): JsonResponse
    {
        $customers = User::latest()->get();
        return response()->json([
            'status' => 'success',
            'data' => $customers,
        ]);
    }
}
