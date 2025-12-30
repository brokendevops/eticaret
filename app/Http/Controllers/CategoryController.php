<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
     // Bir kategorideki ürünleri göster
    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        $products = $category->products()
            ->where('is_active', true)
            ->latest()
            ->paginate(12);
        
        return view('categories.show', compact('category', 'products'));
    }
}
