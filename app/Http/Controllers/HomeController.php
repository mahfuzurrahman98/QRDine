<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Coupon;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {
    public function dashboard() {
        $user = Auth::user();
        $isMasterAdmin = $user->type === 1;

        $data = [];

        if ($isMasterAdmin) {
            // Master Admin Data
            $totalRevenue = Order::where('status', 6)->sum('amount');

            $totalOrders = Order::where('status', 6)->count();

            $totalCustomers = Order::where('status', 6)
                ->distinct('customer_phone')
                ->count();

            $activeCoupons = Coupon::where('valid_from', '<=', now())
                ->where('valid_to', '>=', now())
                ->count();

            $ordersToday = Order::where('status', 6)
                ->whereDate('created_at', today())
                ->count();

            $ordersLast7Days = Order::where('status', 6)
                ->whereDate('created_at', '>=', now()->subDays(7))
                ->count();

            $ordersLast30Days = Order::where('status', 6)
                ->whereDate('created_at', '>=', now()->subDays(30))
                ->count();

            $salesToday = Order::where('status', 6)
                ->whereDate('created_at', today())
                ->sum('amount');

            $salesLast7Days = Order::where('status', 6)
                ->whereDate('created_at', '>=', now()->subDays(7))
                ->sum('amount');

            $salesLast30Days = Order::where('status', 6)
                ->whereDate('created_at', '>=', now()->subDays(30))
                ->sum('amount');

            $topPerformingRestaurants = Restaurant::select('id', 'name')
                ->withCount(['orders' => function ($query) {
                    $query->where('status', 6);
                }])
                ->orderBy('orders_count', 'desc')
                ->limit(7)
                ->get();

            $recentOrders = Order::with('restaurant')
                ->orderBy('created_at', 'desc')
                ->limit(7)
                ->get();

            $data = [
                'totalRevenue' => $totalRevenue,
                'totalOrders' => $totalOrders,
                'totalCustomers' => $totalCustomers,
                'activeCoupons' => $activeCoupons,
                'ordersToday' => $ordersToday,
                'ordersLast7Days' => $ordersLast7Days,
                'ordersLast30Days' => $ordersLast30Days,
                'salesToday' => $salesToday,
                'salesLast7Days' => $salesLast7Days,
                'salesLast30Days' => $salesLast30Days,
                'topPerformingRestaurants' => $topPerformingRestaurants,
                'recentOrders' => $recentOrders
            ];
        } else {
            // Resto Owner Data
            $restaurantId = $user->restaurant->id;

            $totalRevenue = Order::where('restaurant_id', $restaurantId)
                ->where('status', 6)
                ->sum('amount');

            $totalOrders = Order::where('restaurant_id', $restaurantId)
                ->where('status', 6)
                ->count();

            $totalCustomers = Order::where('restaurant_id', $restaurantId)
                ->where('status', 6)
                ->distinct('customer_email')
                ->count();

            $activeCoupons = Coupon::where('valid_from', '<=', now())
                ->where('valid_to', '>=', now())
                ->count();

            $ordersToday = Order::where('restaurant_id', $restaurantId)
                ->where('status', 6)
                ->whereDate('created_at', today())
                ->count();

            $ordersLast7Days = Order::where('restaurant_id', $restaurantId)
                ->where('status', 6)
                ->whereDate('created_at', '>=', now()->subDays(7))
                ->count();

            $ordersLast30Days = Order::where('restaurant_id', $restaurantId)
                ->where('status', 6)
                ->whereDate('created_at', '>=', now()->subDays(30))
                ->count();

            $salesToday = Order::where('restaurant_id', $restaurantId)
                ->where('status', 6)
                ->whereDate('created_at', today())
                ->sum('amount');

            $salesLast7Days = Order::where('restaurant_id', $restaurantId)
                ->where('status', 6)
                ->whereDate('created_at', '>=', now()->subDays(7))
                ->sum('amount');

            $salesLast30Days = Order::where('restaurant_id', $restaurantId)
                ->where('status', 6)
                ->whereDate('created_at', '>=', now()->subDays(30))
                ->sum('amount');

            // Fetch orders for the specific restaurant (or all orders if master admin)
            $orders = Order::where('restaurant_id', $restaurantId)
                ->where('status', 6)
                ->orderBy('created_at', 'desc')
                ->get();

            // Iterate through each order and accumulate item quantities
            foreach ($orders as $order) {
                $items = $order->items; // This will return the decoded JSON array of items
                foreach ($items as $item) {
                    if (isset($itemQuantities[$item['id']])) {
                        $itemQuantities[$item['id']]['quantity'] += $item['quantity'];
                    } else {
                        $itemQuantities[$item['id']] = [
                            'id' => $item['id'],
                            'name' => $item['name'],
                            'quantity' => $item['quantity']
                        ];
                    }
                }
            }

            // Sort the items by quantity in descending order and take the top 10
            $topSellingItems = collect($itemQuantities)
                ->sortByDesc('quantity')
                ->take(7)
                ->values();

            $recentOrders = Order::where('restaurant_id', $restaurantId)
                ->orderBy('created_at', 'desc')
                ->take(7)
                ->get();

            $data = [
                'totalRevenue' => $totalRevenue,
                'totalOrders' => $totalOrders,
                'totalCustomers' => $totalCustomers,
                'activeCoupons' => $activeCoupons,
                'ordersToday' => $ordersToday,
                'ordersLast7Days' => $ordersLast7Days,
                'ordersLast30Days' => $ordersLast30Days,
                'salesToday' => $salesToday,
                'salesLast7Days' => $salesLast7Days,
                'salesLast30Days' => $salesLast30Days,
                'topSellingItems' => $topSellingItems,
                'recentOrders' => $recentOrders
            ];
        }

        // dd($topSellingItems);

        return view('dashboard', $data);
    }
}
