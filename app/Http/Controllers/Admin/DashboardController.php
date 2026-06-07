<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'orders_today'   => Order::whereDate('created_at', today())->count(),
            'orders_pending' => Order::where('status', 'pending')->count(),
            'orders_total'   => Order::count(),
            'articles_total' => Article::where('status', 'published')->count(),
        ];

        $recentOrders = Order::with('items')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}