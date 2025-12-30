<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Yeni Urun Ekle') }}
            </h2>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                ← Geri Dön
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Hata Mesajları -->
                    @if($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Ürün Adı -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Ürün Adı <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
<!-- Ürün Resim URL (Opsiyonel) -->
<div>
    <label for="image_url" class="block text-sm font-medium text-gray-700 mb-2">
        Ürün Resim URL (Opsiyonel)
    </label>
    <input type="url" name="image_url" id="image_url" 
           value="{{ old('image_url', $product->images ?? '') }}"
           placeholder="https://example.com/image.jpg"
           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
    <p class="mt-1 text-sm text-gray-500">Boş bırakırsanız otomatik kategoriye göre resim seçilir</p>
</div>
                        <!-- Kategori -->
                        <div>
                            
                            <label for="category_id" class="block text-sm font-medium text-gray-700">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select name="category_id" id="category_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Kategori Seçin</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Açıklama -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">
                                Açıklama
                            </label>
                            <textarea name="description" id="description" rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
                        </div>

                        <!-- Fiyat ve İndirimli Fiyat -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">
                                    Fiyat (₺) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="price" id="price" step="0.01" min="0" value="{{ old('price') }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="sale_price" class="block text-sm font-medium text-gray-700">
                                    İndirimli Fiyat (₺)
                                </label>
                                <input type="number" name="sale_price" id="sale_price" step="0.01" min="0" value="{{ old('sale_price') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <p class="mt-1 text-sm text-gray-500">İndirim yoksa boş bırakın</p>
                            </div>
                        </div>

                        <!-- Stok ve SKU -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700">
                                    Stok Miktarı <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="stock" id="stock" min="0" value="{{ old('stock', 0) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="sku" class="block text-sm font-medium text-gray-700">
                                    SKU (Stok Kodu)
                                </label>
                                <input type="text" name="sku" id="sku" value="{{ old('sku') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        <!-- Durum ve Öne Çıkan -->
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" 
                                       {{ old('is_active', true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                    Ürün Aktif
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="is_featured" id="is_featured" value="1" 
                                       {{ old('is_featured') ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                                    Öne Çıkan Ürün
                                </label>
                            </div>
                        </div>

                        <!-- Butonlar -->
                        <div class="flex items-center justify-end space-x-4 pt-4">
                            <a href="{{ route('admin.products.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                İptal
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Ürünü Kaydet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>