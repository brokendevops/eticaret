<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Sepeti göster
    public function index()
    {
        // Şimdilik basit session tabanlı sepet
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    // Sepete ürün ekle
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $cart = session()->get('cart', []);

        // Ürün zaten sepette mi?
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->sale_price ?? $product->price,
                'quantity' => 1,
                'image' => ! empty($images) ? $images[0] : null,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Ürün sepete eklendi!');
    }

    // Sepetten ürün çıkar
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Ürün sepetten çıkarıldı!');
    }

    // Sepetteki ürün miktarını güncelle
    public function update(Request $request, $id)
{
    $cart = session()->get('cart', []);
    
    if (isset($cart[$id])) {
        $quantity = max(1, (int)$request->quantity);
        
        // Stok kontrolü
        $product = Product::find($id);
        if (!$product) {
            return back()->with('error', 'Ürün bulunamadı.');
        }
        
        if ($product->stock < $quantity) {
            return back()->with('error', 'Stokta sadece ' . $product->stock . ' adet var!');
        }
        
        $cart[$id]['quantity'] = $quantity;
        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', 'Miktar güncellendi!');
    }
    
    return redirect()->back()->with('error', 'Ürün sepette bulunamadı.');
}
}
