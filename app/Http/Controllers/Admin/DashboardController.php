<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
     public function index()
    {
        // İstatistikler
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('stock', '<', 10)->count();
        $totalUsers = User::where('role', 'customer')->count();
        
        // Son siparişler
        $recentOrders = Order::with('user')->latest()->limit(5)->get();
        
        // Düşük stoklu ürünler
        $lowStock = Product::where('stock', '<', 10)->limit(5)->get();
        
        return view('admin.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'totalRevenue',
            'totalProducts',
            'lowStockProducts',
            'totalUsers',
            'recentOrders',
            'lowStock'
        ));
    }
}
