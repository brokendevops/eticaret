<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Alışveriş Sepetim') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Başarı Mesajı -->
@if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ session('success') }}
    </div>
@endif

<!-- Hata Mesajı -->
@if(session('error'))
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        {{ session('error') }}
    </div>
@endif

            @if(empty($cart))
                <!-- Boş Sepet -->
                <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Sepetiniz Boş</h3>
                    <p class="text-gray-600 mb-6">Henüz sepetinize ürün eklemediniz.</p>
                    <a href="{{ route('products.index') }}" 
                       class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded">
                        Alışverişe Başla
                    </a>
                </div>
            @else
                <!-- Sepet İçeriği -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Sepetteki Ürünler -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <div class="p-6 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    Sepetim ({{ count($cart) }} Ürün)
                                </h3>
                            </div>
                            
                            <div class="divide-y divide-gray-200">
                                @foreach($cart as $id => $item)
                                    <div class="p-6 flex gap-4">
                                        <!-- Ürün Görseli -->
                                        <div class="flex-shrink-0 w-24 h-24 bg-gray-200 rounded flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        
                                        <!-- Ürün Bilgileri -->
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-base font-medium text-gray-900 mb-2">
                                                {{ $item['name'] }}
                                            </h4>
                                            
                                            <!-- Miktar ve Fiyat -->
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-3">
                                                    <span class="text-sm text-gray-600">Miktar:</span>
                                                    <div class="flex items-center border border-gray-300 rounded">
                                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="quantity" value="{{ $item['quantity'] - 1 }}">
                                                            <button type="submit" 
                                                                    class="px-3 py-1 hover:bg-gray-100"
                                                                    {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                                                -
                                                            </button>
                                                        </form>
                                                        <span class="px-4 py-1 border-x border-gray-300">{{ $item['quantity'] }}</span>
                                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                                            <button type="submit" class="px-3 py-1 hover:bg-gray-100">
                                                                +
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                                
                                                <div class="text-right">
                                                    <p class="text-sm text-gray-600">Birim Fiyat: ₺{{ number_format($item['price'], 2) }}</p>
                                                    <p class="text-lg font-bold text-gray-900">
                                                        ₺{{ number_format($item['price'] * $item['quantity'], 2) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Sil Butonu -->
                                        <div>
                                            <form action="{{ route('cart.remove', $id) }}" method="POST" 
                                                  onsubmit="return confirm('Bu ürünü sepetten çıkarmak istediğinize emin misiniz?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Sipariş Özeti -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Sipariş Özeti</h3>
                            
                            <div class="space-y-3 mb-4">
                                <div class="flex justify-between text-gray-600">
                                    <span>Ara Toplam</span>
                                    <span>₺{{ number_format($total, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>KDV (%20)</span>
                                    <span>₺{{ number_format($total * 0.20, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Kargo</span>
                                    <span>₺50.00</span>
                                </div>
                                <div class="border-t border-gray-200 pt-3">
                                    <div class="flex justify-between text-lg font-bold text-gray-900">
                                        <span>Toplam</span>
                                        <span>₺{{ number_format($total + ($total * 0.20) + 50, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            @auth
                                <a href="{{ route('orders.create') }}" 
                                   class="block w-full bg-green-500 hover:bg-green-600 text-white text-center font-bold py-3 px-4 rounded mb-3">
                                    Siparişi Tamamla
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="block w-full bg-blue-500 hover:bg-blue-600 text-white text-center font-bold py-3 px-4 rounded mb-3">
                                    Giriş Yapın
                                </a>
                                <p class="text-sm text-gray-600 text-center">
                                    Sipariş vermek için giriş yapmalısınız
                                </p>
                            @endauth
                            
                            <a href="{{ route('products.index') }}" 
                               class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-800 text-center font-bold py-3 px-4 rounded">
                                Alışverişe Devam Et
                            </a>
                        </div>
                    </div>

                </div>
            @endif

        </div>
    </div>
</x-app-layout>