<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use AuthorizesRequests;
     // Tüm ürünleri listele
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(20);
        
        return view('admin.products.index', compact('products'));
    }
    
    // Yeni ürün oluşturma sayfası
    public function create()
    {
        $this->authorize('create', Product::class);
        
        $categories = Category::where('is_active', true)->get();
        
        return view('admin.products.create', compact('categories'));
    }
    
    // Ürünü kaydet
    public function store(Request $request)
    {
        $this->authorize('create', Product::class);
        
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|unique:products,sku',
            'is_featured' => 'boolean',
            'is_active' => 'boolean'
        ]);

        // Resim URL'si varsa kaydet
if ($request->filled('image_url')) {
    $validated['images'] = json_encode([$request->image_url]);
} else {
    $validated['images'] = null;
}
        
        $validated['slug'] = Str::slug($request->name);
        
        Product::create($validated);
        
        return redirect()->route('admin.products.index')->with('success', 'Ürün başarıyla oluşturuldu!');
    }
    
    // Ürün düzenleme sayfası
    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        
        $categories = Category::where('is_active', true)->get();
        
        return view('admin.products.edit', compact('product', 'categories'));
    }
    
    // Ürünü güncelle
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);
        
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'is_featured' => 'boolean',
            'is_active' => 'boolean'
        ]);
        
        // Resim URL'si varsa kaydet
if ($request->filled('image_url')) {
    $validated['images'] = json_encode([$request->image_url]);
} else {
    $validated['images'] = null;
}

        $validated['slug'] = Str::slug($request->name);
        
        $product->update($validated);
        
        return redirect()->route('admin.products.index')->with('success', 'Ürün başarıyla güncellendi!');
    }
    
    // Ürünü sil
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        
        $product->delete();
        
        return redirect()->route('admin.products.index')->with('success', 'Ürün başarıyla silindi!');
    }
}
