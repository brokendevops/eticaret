<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Product;

class CheckStock
{
    public function handle(Request $request, Closure $next): Response
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        if ($productId) {
            $product = Product::find($productId);
            
            // Ürün bulunamadı veya stok yok
            if (!$product) {
                return back()->with('error', 'Ürün bulunamadı.');
            }
            
            if (!$product->is_active) {
                return back()->with('error', 'Bu ürün şu an satışta değil.');
            }
            
            if ($product->stock < $quantity) {
                return back()->with('error', 'Üzgünüz, bu ürün stokta yeterli miktarda yok. Mevcut stok: ' . $product->stock);
            }
        }

        return $next($request);
    }
}