<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ürünler') }}
        </h2>
    </x-slot>

    <!-- Başarı Mesajı -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Kategoriler -->
            <div class="mb-8">
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Kategoriler</h3>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('products.index') }}"
                            class="px-4 py-2 rounded-full text-sm font-medium transition
                                  {{ !request('category') ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Tümü
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('categories.show', $category->slug) }}"
                                class="px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Ürün Sayısı -->
            <div class="mb-6 flex justify-between items-center">
                <p class="text-gray-600">
                    <span class="font-semibold">{{ $products->total() }}</span> ürün bulundu
                </p>
            </div>

            <!-- Ürün Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($products as $product)
                    <div class="bg-white rounded-lg shadow-sm hover:shadow-lg transition overflow-hidden group">
                        <!-- Ürün Görseli Placeholder -->
                        <div class="relative bg-gray-200 h-64 flex items-center justify-center">
                           <!-- Yeni -->
<div class="h-64 overflow-hidden">
    <img src="{{ $product->getImageUrl(400, 300) }}" 
         alt="{{ $product->name }}"
         class="w-full h-full object-cover">
</div>

                            <!-- Öne Çıkan Badge -->
                            @if($product->is_featured)
                                <span
                                    class="absolute top-2 left-2 bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-1 rounded">
                                    ⭐ Öne Çıkan
                                </span>
                            @endif

                            <!-- İndirim Badge -->
                            @if($product->sale_price)
                                <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                    {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% İndirim
                                </span>
                            @endif

                            <!-- Stok Durumu -->
                            @if($product->stock == 0)
                                <span
                                    class="absolute bottom-2 left-2 right-2 bg-gray-900 bg-opacity-75 text-white text-center text-sm font-medium py-2 rounded">
                                    Stokta Yok
                                </span>
                            @elseif($product->stock < 10)
                                <span
                                    class="absolute bottom-2 left-2 bg-orange-500 text-white text-xs font-bold px-2 py-1 rounded">
                                    Son {{ $product->stock }} adet!
                                </span>
                            @endif
                        </div>

                        <!-- Ürün Bilgileri -->
                        <div class="p-4">
                            <!-- Kategori -->
                            <p class="text-xs text-gray-500 mb-1">{{ $product->category->name }}</p>

                            <!-- Ürün Adı -->
                            <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 h-12">
                                <a href="{{ route('products.show', $product->slug) }}" class="hover:text-blue-600">
                                    {{ $product->name }}
                                </a>
                            </h3>

                            <!-- Açıklama -->
                            @if($product->description)
                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                    {{ Str::limit($product->description, 80) }}
                                </p>
                            @endif

                            <!-- Fiyat -->
                            <div class="flex items-center justify-between mb-3">
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

                            <!-- Butonlar -->
                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ route('products.show', $product->slug) }}"
                                    class="flex-1 bg-blue-500 hover:bg-blue-600 text-white text-center py-1 px-2 rounded font-medium transition">
                                    Detay
                                </a>

                                @if($product->stock > 0)
                                    <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit"
                                            class="w-full bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded font-medium transition">
                                            Sepete Ekle
                                        </button>
                                    </form>
                                @else
                                    <button disabled
                                        class="flex-1 bg-gray-300 text-gray-500 py-2 px-4 rounded font-medium cursor-not-allowed">
                                        Stokta Yok
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-6">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                            </path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Ürün bulunamadı</h3>
                        <p class="mt-1 text-sm text-gray-500">Henüz bu kategoride ürün bulunmamaktadır.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>

        </div>
    </div>
</x-app-layout>