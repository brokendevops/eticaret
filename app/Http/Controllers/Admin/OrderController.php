<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderController extends Controller
{
    use AuthorizesRequests;
     // Tüm siparişleri listele
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();
        
        // Durum filtreleme
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Ödeme durumu filtreleme
        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }
        
        $orders = $query->paginate(20);
        
        return view('admin.orders.index', compact('orders'));
    }
    
    // Sipariş detayı
    public function show(Order $order)
    {
        $order->load('user', 'orderItems.product');
        
        return view('admin.orders.show', compact('order'));
    }
    
    // Sipariş durumunu güncelle
    public function updateStatus(Request $request, Order $order)
    {
        $this->authorize('update', $order);
        
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);
        
        $order->update(['status' => $request->status]);
        
        return redirect()->back()->with('success', 'Sipariş durumu güncellendi!');
    }
    
    // Ödeme durumunu güncelle
    public function updatePaymentStatus(Request $request, Order $order)
    {
        $this->authorize('update', $order);
        
        $request->validate([
            'payment_status' => 'required|in:unpaid,paid,failed,refunded'
        ]);
        
        $order->update(['payment_status' => $request->payment_status]);
        
        return redirect()->back()->with('success', 'Ödeme durumu güncellendi!');
    }
}
