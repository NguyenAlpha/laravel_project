<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Hiển thị trang thống kê
     * @return \Illuminate\Contracts\View\View
     */
    function index()
    {
        $dashboard = [];

        $dashboard['totalOrders'] = Order::count();
        $dashboard['totalUsers'] = User::role('customer')->count();
        $dashboard['totalProducts'] = Product::where('status', '!=', 'đã xóa')->count();
        $dashboard['totalRevenue'] = Order::getTotalAmount();

        $monthlyRevenue = Order::selectRaw('YEAR(order_date) as year, MONTH(order_date) as month, SUM(total_amount) as revenue')
            ->where('status', 'đã nhận hàng')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();

        $dashboard['orders'] = Order::with('user')->orderBy('order_date', 'desc')->limit(5)->get();

        // $monthRevenue = Order::getTotalAmount(now()->startOfMonth(), now()->endOfMonth());

        return view('admin.dashboard.index', compact('dashboard', 'monthlyRevenue'));
    }
}
