<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Sipariş Detayı') }} - {{ $order->order_number }}
            </h2>
            <a href="{{ route('admin.orders.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                ← Geri Dön
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Başarı Mesajı -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Sol Taraf - Sipariş Detayları -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Müşteri Bilgileri -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Müşteri Bilgileri</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Ad Soyad</p>
                                <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">E-posta</p>
                                <p class="font-medium text-gray-900">{{ $order->user->email }}</p>
                            </div>
                            @if($order->user->phone)
                                <div>
                                    <p class="text-sm text-gray-500">Telefon</p>
                                    <p class="font-medium text-gray-900">{{ $order->user->phone }}</p>
                                </div>
                            @endif
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

                    <!-- Ürünler -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Sipariş Ürünleri</h3>
                        
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

                    <!-- Notlar -->
                    @if($order->notes)
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Sipariş Notu</h3>
                            <p class="text-gray-600">{{ $order->notes }}</p>
                        </div>
                    @endif

                </div>

                <!-- Sağ Taraf - Durum ve Özet -->
                <div class="lg:col-span-1 space-y-6">
                    
                    <!-- Sipariş Durumu Güncelleme -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Sipariş Durumu</h3>
                        
                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="mb-4">
                            @csrf
                            @method('PATCH')
                            
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Durum Değiştir
                            </label>
                            <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm mb-3">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Beklemede</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Hazırlanıyor</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Kargoya Verildi</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Teslim Edildi</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>İptal Edildi</option>
                            </select>
                            
                            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                Durumu Güncelle
                            </button>
                        </form>

                        <!-- Mevcut Durum -->
                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-500 mb-2">Mevcut Durum</p>
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
                        </div>
                    </div>

                    <!-- Ödeme Durumu Güncelleme -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Ödeme Durumu</h3>
                        
                        <form action="{{ route('admin.orders.updatePayment', $order) }}" method="POST" class="mb-4">
                            @csrf
                            @method('PATCH')
                            
                            <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-2">
                                Ödeme Durumu Değiştir
                            </label>
                            <select name="payment_status" id="payment_status" class="w-full rounded-md border-gray-300 shadow-sm mb-3">
                                <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Ödenmedi</option>
                                <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Ödendi</option>
                                <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Başarısız</option>
                                <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>İade Edildi</option>
                            </select>
                            
                            <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                                Ödeme Durumunu Güncelle
                            </button>
                        </form>

                        <!-- Mevcut Ödeme Durumu -->
                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-500 mb-2">Mevcut Ödeme Durumu</p>
                            <span class="px-4 py-2 rounded-full text-sm font-semibold
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

                        <!-- Ödeme Yöntemi -->
                        <div class="pt-4 border-t border-gray-200 mt-4">
                            <p class="text-sm text-gray-500 mb-1">Ödeme Yöntemi</p>
                            <p class="font-medium text-gray-900">
                                @if($order->payment_method == 'credit_card') Kredi Kartı
                                @elseif($order->payment_method == 'bank_transfer') Banka Havalesi
                                @else Kapıda Ödeme
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Sipariş Özeti -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Sipariş Özeti</h3>
                        
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Sipariş No:</span>
                                <span class="font-medium">{{ $order->order_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tarih:</span>
                                <span class="font-medium">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 mt-4 pt-4 space-y-2 text-sm">
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

                </div>

            </div>
        </div>
    </div>
</x-admin-layout>