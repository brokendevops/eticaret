<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
    $products = Product::with('category')
    ->where('is_active', true)
    ->latest()
    ->paginate(12);  
    
    $categories = Category::where('is_active', true)->get();

    return view('products.index', compact('products','categories'));
    }

     public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with('category')
            ->firstOrFail();
        
        // İlgili ürünler (aynı kategoriden)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();
        
        return view('products.show', compact('product', 'relatedProducts'));
    }

}
