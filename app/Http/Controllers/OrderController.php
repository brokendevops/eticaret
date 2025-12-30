<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Events\OrderPlaced;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    use AuthorizesRequests;
    
    // Kullanıcının siparişlerini göster
    public function index()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);
        
        return view('orders.index', compact('orders'));
    }
    
    // Sipariş detayı
    public function show(Order $order)
    {
        // Policy kontrolü: Kullanıcı bu siparişi görebilir mi?
        $this->authorize('view', $order);
        
        $order->load('orderItems.product');
        
        return view('orders.show', compact('order'));
    }
    
    // Sipariş oluşturma sayfası
    public function create()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Sepetiniz boş!');
        }
        
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('orders.create', compact('cart', 'total'));
    }
    
    // Siparişi kaydet
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_state' => 'required|string',
            'shipping_zip' => 'required|string',
            'payment_method' => 'required|string'
        ]);
        
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Sepetiniz boş!');
        }
        
        // Toplam hesapla
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        $shipping = 50; // Sabit kargo ücreti
        $tax = $subtotal * 0.20; // %20 KDV
        $total = $subtotal + $shipping + $tax;
        
        // Sipariş oluştur
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'total' => $total,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'payment_method' => $request->payment_method,
            'shipping_address' => $request->shipping_address,
            'shipping_city' => $request->shipping_city,
            'shipping_state' => $request->shipping_state,
            'shipping_zip' => $request->shipping_zip,
            'shipping_country' => 'Turkey',
            'notes' => $request->notes
        ]);
        
        // Sipariş itemlerini oluştur
        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['price'] * $item['quantity']
            ]);
        }
        
        // Event tetikle (email gönder, stok güncelle)
        event(new OrderPlaced($order));
        
        // Sepeti temizle
        session()->forget('cart');
        
        // Ödeme sayfasına yönlendir (DEĞİŞTİRİLDİ)
        return redirect()->route('orders.payment', $order);
    }
    
    // Sipariş iptal et
    public function cancel(Order $order)
    {
        $this->authorize('cancel', $order);
        
        $order->update(['status' => 'cancelled']);
        
        return redirect()->back()->with('success', 'Sipariş iptal edildi.');
    }
    
    // Ödeme sayfası
    public function payment(Order $order)
    {
        $this->authorize('view', $order);
        
        // Zaten ödenmiş siparişler için ödeme sayfasına izin verme
        if ($order->payment_status === 'paid') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Bu sipariş zaten ödenmiş.');
        }
        
        return view('orders.payment', compact('order'));
    }

    // Ödeme işlemi (mockup)
    public function processPayment(Request $request, Order $order)
    {
        $this->authorize('view', $order);
        
        // Kredi kartı bilgilerini validate et (mockup için)
        $request->validate([
            'card_number' => 'required|digits:16',
            'card_name' => 'required|string',
            'card_expiry' => 'required|string',
            'card_cvv' => 'required|digits:3',
        ]);
        
        // Mockup ödeme - Her zaman başarılı
        // Gerçek entegrasyonda burada ödeme gateway'ine istek atılır
        
        $order->update([
            'payment_status' => 'paid'
        ]);
        
        // Sipariş detay sayfasına yönlendir (DEĞİŞTİRİLDİ)
        return redirect()->route('orders.show', $order)
            ->with('success', 'Ödemeniz başarıyla alındı! Siparişiniz hazırlanıyor.');
    }
}