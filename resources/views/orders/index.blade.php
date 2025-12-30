<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Siparişlerim') }}
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

            @if($orders->count() > 0)
                <!-- Siparişler -->
                <div class="space-y-4">
                    @foreach($orders as $order)
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                            <!-- Sipariş Header -->
                            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                                <div class="flex flex-wrap items-center justify-between gap-4">
                                    <div class="flex flex-wrap items-center gap-4">
                                        <div>
                                            <p class="text-xs text-gray-500">Sipariş No</p>
                                            <p class="font-semibold text-gray-900">{{ $order->order_number }}</p>
                                        </div>
                                        <div class="border-l border-gray-300 pl-4">
                                            <p class="text-xs text-gray-500">Sipariş Tarihi</p>
                                            <p class="font-medium text-gray-900">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                                        </div>
                                        <div class="border-l border-gray-300 pl-4">
                                            <p class="text-xs text-gray-500">Toplam Tutar</p>
                                            <p class="font-bold text-gray-900">₺{{ number_format($order->total, 2) }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center gap-3">
                                        <!-- Sipariş Durumu -->
                                        <span class="px-4 py-2 rounded-full text-sm font-semibold
                                            @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                            @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                                            @elseif($order->status == 'delivered') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            @if($order->status == 'pending') Beklemede
                                            @elseif($order->status == 'processing') Hazırlanıyor
                                            @elseif($order->status == 'shipped') Kargoda
                                            @elseif($order->status == 'delivered') Teslim Edildi
                                            @else İptal Edildi
                                            @endif
                                        </span>
                                        
                                        <!-- Ödeme Durumu -->
                                        <span class="px-3 py-1 rounded text-xs font-semibold
                                            @if($order->payment_status == 'paid') bg-green-100 text-green-800
                                            @elseif($order->payment_status == 'unpaid') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            @if($order->payment_status == 'paid') Ödendi
                                            @elseif($order->payment_status == 'unpaid') Ödenmedi
                                            @elseif($order->payment_status == 'failed') Başarısız
                                            @else İade
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Sipariş İçeriği -->
                            <div class="p-6">
                                <!-- Ürünler -->
                                <div class="space-y-3 mb-4">
                                    @foreach($order->orderItems as $item)
                                        <div class="flex items-center gap-4">
                                            <div class="flex-shrink-0 w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="font-medium text-gray-900 truncate">{{ $item->product_name }}</p>
                                                <p class="text-sm text-gray-600">Miktar: {{ $item->quantity }} x ₺{{ number_format($item->price, 2) }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="font-bold text-gray-900">₺{{ number_format($item->total, 2) }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Adres -->
                                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                    <p class="text-xs text-gray-500 mb-1">Teslimat Adresi</p>
                                    <p class="text-sm text-gray-700">
                                        {{ $order->shipping_address }}, {{ $order->shipping_state }}, {{ $order->shipping_city }} {{ $order->shipping_zip }}
                                    </p>
                                </div>

                                <!-- Butonlar -->
                                <div class="flex flex-wrap gap-3">
                                    <a href="{{ route('orders.show', $order) }}" 
                                       class="flex-1 min-w-[200px] bg-blue-500 hover:bg-blue-600 text-white text-center font-medium py-2 px-4 rounded transition">
                                        Sipariş Detayı
                                    </a>
                                    
                                    @if($order->status == 'pending')
                                        <form action="{{ route('orders.cancel', $order) }}" method="POST" 
                                              onsubmit="return confirm('Siparişi iptal etmek istediğinize emin misiniz?');"
                                              class="flex-1 min-w-[200px]">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded transition">
                                                Siparişi İptal Et
                                            </button>
                                        </form>
                                    @endif

                                    @if($order->status == 'delivered')
                                        <button class="flex-1 min-w-[200px] bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded transition">
                                            Tekrar Sipariş Ver
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $orders->links() }}
                </div>

            @else
                <!-- Boş Durum -->
                <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Henüz Siparişiniz Yok</h3>
                    <p class="text-gray-600 mb-6">Hemen alışverişe başlayın ve ilk siparişinizi verin!</p>
                    <a href="{{ route('products.index') }}" 
                       class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded">
                        Ürünleri Keşfet
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>