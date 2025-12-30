<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900">
                Ürünler
            </a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-900 font-semibold">{{ $category->name }}</span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Kategori Banner -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg p-8 mb-8 text-white">
                <h1 class="text-4xl font-bold mb-2">{{ $category->name }}</h1>
                @if($category->description)
                    <p class="text-blue-100 text-lg">{{ $category->description }}</p>
                @endif
                <p class="text-blue-200 mt-2">{{ $products->total() }} ürün bulundu</p>
            </div>

            <!-- Kategoriler (Yan Menü) -->
            <div class="mb-8">
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Kategoriler</h3>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('products.index') }}" 
                           class="px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                            Tümü
                        </a>
                        @php
                            $allCategories = \App\Models\Category::where('is_active', true)->get();
                        @endphp
                        @foreach($allCategories as $cat)
                            <a href="{{ route('categories.show', $cat->slug) }}" 
                               class="px-4 py-2 rounded-full text-sm font-medium transition
                                      {{ $cat->id == $category->id ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            @if($products->count() > 0)
                <!-- Ürün Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-lg shadow-sm hover:shadow-lg transition overflow-hidden group flex flex-col h-full">
                            <!-- Ürün Görseli -->
                            <div class="relative bg-gray-200 h-64 flex items-center justify-center">
                                <!-- Yeni -->
<div class="h-64 overflow-hidden">
    <img src="{{ $product->getImageUrl(400, 300) }}" 
         alt="{{ $product->name }}"
         class="w-full h-full object-cover">
</div>
                                
                                @if($product->is_featured)
                                    <span class="absolute top-2 left-2 bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-1 rounded">
                                        ⭐ Öne Çıkan
                                    </span>
                                @endif
                                
                                @if($product->sale_price)
                                    <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                        {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% İndirim
                                    </span>
                                @endif

                                @if($product->stock == 0)
                                    <span class="absolute bottom-2 left-2 right-2 bg-gray-900 bg-opacity-75 text-white text-center text-sm font-medium py-2 rounded">
                                        Stokta Yok
                                    </span>
                                @elseif($product->stock < 10)
                                    <span class="absolute bottom-2 left-2 bg-orange-500 text-white text-xs font-bold px-2 py-1 rounded">
                                        Son {{ $product->stock }} adet!
                                    </span>
                                @endif
                            </div>

                            <!-- Ürün Bilgileri -->
                            <div class="p-4 flex-1 flex flex-col">
                                <p class="text-xs text-gray-500 mb-1">{{ $product->category->name }}</p>
                                
                                <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 h-12">
                                    <a href="{{ route('products.show', $product->slug) }}" class="hover:text-blue-600">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                
                                @if($product->description)
                                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                        {{ Str::limit($product->description, 80) }}
                                    </p>
                                @endif
                                
                                <div class="flex items-center justify-between mb-3 mt-auto">
                                    <div>
                                        @if($product->sale_price)
                                            <div class="flex items-center gap-2">
                                                <span class="text-lg font-bold text-red-600">
                                                    ₺{{ number_format($product->sale_price, 2) }}
                                                </span>
                                                <span class="text-sm text-gray-500 line-through">
                                                    ₺{{ number_format($product->price, 2) }}
                                                </span>
                                            </div>
                                        @else
                                            <span class="text-lg font-bold text-gray-900">
                                                ₺{{ number_format($product->price, 2) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-2">
                                    <a href="{{ route('products.show', $product->slug) }}" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white text-center py-2 px-4 rounded font-medium transition">
                                        Detay
                                    </a>
                                    
                                    @if($product->stock > 0)
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" 
                                                    class="w-full bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded font-medium transition">
                                                Sepete Ekle
                                            </button>
                                        </form>
                                    @else
                                        <button disabled 
                                                class="bg-gray-300 text-gray-500 py-2 px-4 rounded font-medium cursor-not-allowed">
                                            Stokta Yok
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>

            @else
                <!-- Boş Durum -->
                <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Bu Kategoride Ürün Bulunamadı</h3>
                    <p class="text-gray-600 mb-6">Henüz bu kategoride ürün eklenmemiş.</p>
                    <a href="{{ route('products.index') }}" 
                       class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded">
                        Tüm Ürünleri Gör
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>