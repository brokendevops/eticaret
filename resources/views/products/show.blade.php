<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900">
                Ürünler
            </a>
            <span class="text-gray-400">/</span>
            <a href="{{ route('categories.show', $product->category->slug) }}" class="text-gray-600 hover:text-gray-900">
                {{ $product->category->name }}
            </a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-900 font-semibold">{{ $product->name }}</span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Başarı/Hata Mesajları -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Ürün Detayı -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                    
                  <!-- Sol Taraf - Görsel -->
<div>
    <div class="bg-gray-100 rounded-lg overflow-hidden" style="height: 400px;">
        <img src="{{ $product->getImageUrl(600, 400) }}" 
             alt="{{ $product->name }}"
             class="w-full h-full object-contain">
    </div>
    
    <!-- Badge'ler -->
    <div class="flex gap-2 mt-4">
        @if($product->is_featured)
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                ⭐ Öne Çıkan Ürün
            </span>
        @endif
        
        @if($product->sale_price)
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% İndirim
            </span>
        @endif
    </div>
</div>

                    <!-- Sağ Taraf - Bilgiler -->
                    <div>
                        <!-- Kategori -->
                        <a href="{{ route('categories.show', $product->category->slug) }}" 
                           class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                            {{ $product->category->name }}
                        </a>

                        <!-- Ürün Adı -->
                        <h1 class="text-3xl font-bold text-gray-900 mt-2 mb-4">
                            {{ $product->name }}
                        </h1>

                        <!-- SKU -->
                        @if($product->sku)
                            <p class="text-sm text-gray-500 mb-4">
                                Ürün Kodu: {{ $product->sku }}
                            </p>
                        @endif

                        <!-- Fiyat -->
                        <div class="mb-6">
                            @if($product->sale_price)
                                <div class="flex items-baseline gap-3">
                                    <span class="text-4xl font-bold text-red-600">
                                        ₺{{ number_format($product->sale_price, 2) }}
                                    </span>
                                    <span class="text-2xl text-gray-500 line-through">
                                        ₺{{ number_format($product->price, 2) }}
                                    </span>
                                </div>
                                <p class="text-sm text-green-600 font-medium mt-1">
                                    ₺{{ number_format($product->price - $product->sale_price, 2) }} tasarruf ediyorsunuz!
                                </p>
                            @else
                                <span class="text-4xl font-bold text-gray-900">
                                    ₺{{ number_format($product->price, 2) }}
                                </span>
                            @endif
                        </div>

                        <!-- Stok Durumu -->
                        <div class="mb-6">
                            @if($product->stock > 0)
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-green-700 font-medium">Stokta var</span>
                                    @if($product->stock < 10)
                                        <span class="text-orange-600 text-sm">(Son {{ $product->stock }} adet!)</span>
                                    @endif
                                </div>
                            @else
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-red-700 font-medium">Stokta yok</span>
                                </div>
                            @endif
                        </div>

                        <!-- Açıklama -->
                        @if($product->description)
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Ürün Açıklaması</h3>
                                <p class="text-gray-600 leading-relaxed">
                                    {{ $product->description }}
                                </p>
                            </div>
                        @endif

                        <!-- Sepete Ekleme Formu -->
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                
                                <!-- Miktar Seçici -->
                                <div>
                                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                        Miktar
                                    </label>
                                    <div class="flex items-center gap-3">
                                        <button type="button" onclick="decreaseQuantity()" 
                                                class="w-10 h-10 rounded-lg border border-gray-300 hover:bg-gray-100 flex items-center justify-center font-bold text-gray-600">
                                            -
                                        </button>
                                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}"
                                               class="w-20 text-center border border-gray-300 rounded-lg py-2">
                                        <button type="button" onclick="increaseQuantity()" 
                                                class="w-10 h-10 rounded-lg border border-gray-300 hover:bg-gray-100 flex items-center justify-center font-bold text-gray-600">
                                            +
                                        </button>
                                        <span class="text-sm text-gray-500">
                                            (Maksimum: {{ $product->stock }})
                                        </span>
                                    </div>
                                </div>

                                <!-- Butonlar -->
                                <div class="flex gap-3">
                                    <button type="submit" 
                                            class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-4 px-6 rounded-lg transition flex items-center justify-center gap-2">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                        Sepete Ekle
                                    </button>
                                    <a href="{{ route('cart.index') }}" 
                                       class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-4 px-6 rounded-lg transition">
                                        Sepete Git
                                    </a>
                                </div>
                            </form>
                        @else
                            <div class="bg-gray-100 border border-gray-300 rounded-lg p-4 text-center">
                                <p class="text-gray-700 font-medium mb-2">Bu ürün şu an stokta yok</p>
                                <a href="{{ route('products.index') }}" 
                                   class="text-blue-600 hover:text-blue-800 font-medium">
                                    Diğer ürünlere göz atın →
                                </a>
                            </div>
                        @endif

                        <!-- Ek Bilgiler -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                    </svg>
                                    Ücretsiz kargo (500 TL üzeri siparişlerde)
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    14 gün içinde iade garantisi
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                    Güvenli ödeme
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- İlgili Ürünler -->
            @if($relatedProducts->count() > 0)
                <div class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Benzer Ürünler</h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $related)
                            <div class="bg-white rounded-lg shadow-sm hover:shadow-lg transition overflow-hidden">
                                <div class="bg-gray-200 h-48 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                                        <a href="{{ route('products.show', $related->slug) }}" class="hover:text-blue-600">
                                            {{ $related->name }}
                                        </a>
                                    </h3>
                                    <div class="text-lg font-bold text-gray-900">
                                        @if($related->sale_price)
                                            ₺{{ number_format($related->sale_price, 2) }}
                                        @else
                                            ₺{{ number_format($related->price, 2) }}
                                        @endif
                                    </div>
                                    <a href="{{ route('products.show', $related->slug) }}" 
                                       class="mt-3 block w-full bg-blue-500 hover:bg-blue-600 text-white text-center py-2 rounded font-medium transition">
                                        Detay
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>

    <script>
        function increaseQuantity() {
            const input = document.getElementById('quantity');
            const max = parseInt(input.getAttribute('max'));
            const current = parseInt(input.value);
            if (current < max) {
                input.value = current + 1;
            }
        }

        function decreaseQuantity() {
            const input = document.getElementById('quantity');
            const current = parseInt(input.value);
            if (current > 1) {
                input.value = current - 1;
            }
        }
    </script>
</x-app-layout>