<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sipariş Detayı') }} - {{ $order->order_number }}
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

            <!-- Sipariş Başarılı Banner -->
            @if(session('order_created'))
                <div class="mb-6 bg-green-50 border-2 border-green-500 rounded-lg p-6 text-center">
                    <div class="flex justify-center mb-4">
                        <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-green-900 mb-2">Siparişiniz Başarıyla Alındı!</h3>
                    <p class="text-green-700 mb-4">Sipariş numaranız: <span class="font-bold">{{ $order->order_number }}</span></p>
                    <p class="text-sm text-green-600">Sipariş detaylarını e-posta adresinize gönderdik.</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Sol Taraf - Sipariş Bilgileri -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Sipariş Durumu -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Sipariş Durumu</h3>
                            <span class="px-4 py-2 rounded-full text-sm font-semibold
                                @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                                @elseif($order->status == 'delivered') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                @if($order->status == 'pending') Beklemede
                                @elseif($order->status == 'processing') Hazırlanıyor
                                @elseif($order->status == 'shipped') Kargoya Verildi
                                @elseif($order->status == 'delivered') Teslim Edildi
                                @else İptal Edildi
                                @endif
                            </span>
                        </div>

                        <!-- Durum Timeline -->
                        <div class="relative">
                            <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                            
                            <div class="space-y-6">
                                <!-- Sipariş Alındı -->
                                <div class="relative flex items-start">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-green-500 text-white z-10">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="font-medium text-gray-900">Sipariş Alındı</p>
                                        <p class="text-sm text-gray-500">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                                    </div>
                                </div>

                                <!-- Hazırlanıyor -->
                                <div class="relative flex items-start">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-full 
                                        {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-600' }} z-10">
                                        @if(in_array($order->status, ['processing', 'shipped', 'delivered']))
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        @else
                                            <span class="text-xs">2</span>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <p class="font-medium {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'text-gray-900' : 'text-gray-500' }}">
                                            Hazırlanıyor
                                        </p>
                                    </div>
                                </div>

                                <!-- Kargoya Verildi -->
                                <div class="relative flex items-start">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-full 
                                        {{ in_array($order->status, ['shipped', 'delivered']) ? 'bg-purple-500 text-white' : 'bg-gray-300 text-gray-600' }} z-10">
                                        @if(in_array($order->status, ['shipped', 'delivered']))
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        @else
                                            <span class="text-xs">3</span>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <p class="font-medium {{ in_array($order->status, ['shipped', 'delivered']) ? 'text-gray-900' : 'text-gray-500' }}">
                                            Kargoya Verildi
                                        </p>
                                    </div>
                                </div>

                                <!-- Teslim Edildi -->
                                <div class="relative flex items-start">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-full 
                                        {{ $order->status == 'delivered' ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600' }} z-10">
                                        @if($order->status == 'delivered')
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        @else
                                            <span class="text-xs">4</span>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <p class="font-medium {{ $order->status == 'delivered' ? 'text-gray-900' : 'text-gray-500' }}">
                                            Teslim Edildi
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- İptal Butonu -->
                        @if($order->status == 'pending')
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <form action="{{ route('orders.cancel', $order) }}" method="POST" 
                                      onsubmit="return confirm('Siparişi iptal etmek istediğinize emin misiniz?');">
                                    @csrf
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 font-medium text-sm">
                                        Siparişi İptal Et
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <!-- Sipariş Detayları -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Sipariş Detayları</h3>
                        
                        <div class="divide-y divide-gray-200">
                            @foreach($order->orderItems as $item)
                                <div class="py-4 flex gap-4">
                                    <div class="flex-shrink-0 w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900 mb-1">{{ $item->product_name }}</h4>
                                        <p class="text-sm text-gray-600">Miktar: {{ $item->quantity }}</p>
                                        <p class="text-sm text-gray-600">Birim Fiyat: ₺{{ number_format($item->price, 2) }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-gray-900">₺{{ number_format($item->total, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Teslimat Adresi -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Teslimat Adresi</h3>
                        <div class="text-gray-600 space-y-1">
                            <p>{{ $order->shipping_address }}</p>
                            <p>{{ $order->shipping_state }}, {{ $order->shipping_city }}</p>
                            <p>{{ $order->shipping_zip }}, {{ $order->shipping_country }}</p>
                        </div>
                    </div>

                </div>

                <!-- Sağ Taraf - Özet -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6 space-y-6">
                        
                        <!-- Sipariş Özeti -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Sipariş Özeti</h3>
                            
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Sipariş No:</span>
                                    <span class="font-medium">{{ $order->order_number }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tarih:</span>
                                    <span class="font-medium">{{ $order->created_at->format('d.m.Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Ödeme:</span>
                                    <span class="font-medium">
                                        @if($order->payment_method == 'credit_card') Kredi Kartı
                                        @elseif($order->payment_method == 'bank_transfer') Banka Havalesi
                                        @else Kapıda Ödeme
                                        @endif
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Ödeme Durumu:</span>
                                    <span class="px-2 py-1 rounded text-xs font-semibold
                                        @if($order->payment_status == 'paid') bg-green-100 text-green-800
                                        @elseif($order->payment_status == 'unpaid') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        @if($order->payment_status == 'paid') Ödendi
                                        @elseif($order->payment_status == 'unpaid') Ödenmedi
                                        @elseif($order->payment_status == 'failed') Başarısız
                                        @else İade Edildi
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between text-gray-600">
                                    <span>Ara Toplam:</span>
                                    <span>₺{{ number_format($order->subtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>KDV:</span>
                                    <span>₺{{ number_format($order->tax, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Kargo:</span>
                                    <span>₺{{ number_format($order->shipping, 2) }}</span>
                                </div>
                                <div class="border-t border-gray-200 pt-2 mt-2">
                                    <div class="flex justify-between text-lg font-bold text-gray-900">
                                        <span>Toplam:</span>
                                        <span>₺{{ number_format($order->total, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Butonlar -->
                        <div class="space-y-2">
                            <a href="{{ route('orders.index') }}" 
                               class="block w-full bg-blue-500 hover:bg-blue-600 text-white text-center font-bold py-3 px-4 rounded">
                                Siparişlerim
                            </a>
                            <a href="{{ route('products.index') }}" 
                               class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-800 text-center font-bold py-3 px-4 rounded">
                                Alışverişe Devam Et
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>