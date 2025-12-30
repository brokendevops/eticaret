<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sipariş Oluştur') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Sol Taraf - Form -->
                <div class="lg:col-span-2">
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf

                        <!-- Teslimat Bilgileri -->
                        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Teslimat Bilgileri</h3>
                            
                            <div class="space-y-4">
                                <!-- Adres -->
                                <div>
                                    <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">
                                        Adres <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="shipping_address" id="shipping_address" rows="3" required
                                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                                </div>

                                <!-- Şehir ve İlçe -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="shipping_city" class="block text-sm font-medium text-gray-700 mb-2">
                                            Şehir <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="shipping_city" id="shipping_city" required
                                               value="{{ old('shipping_city', auth()->user()->city) }}"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>

                                    <div>
                                        <label for="shipping_state" class="block text-sm font-medium text-gray-700 mb-2">
                                            İlçe <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="shipping_state" id="shipping_state" required
                                               value="{{ old('shipping_state', auth()->user()->state) }}"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>

                                <!-- Posta Kodu -->
                                <div>
                                    <label for="shipping_zip" class="block text-sm font-medium text-gray-700 mb-2">
                                        Posta Kodu <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="shipping_zip" id="shipping_zip" required
                                           value="{{ old('shipping_zip', auth()->user()->zip_code) }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Ödeme Yöntemi -->
                        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ödeme Yöntemi</h3>
                            
                            <div class="space-y-3">
                                <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="payment_method" value="credit_card" 
                                           {{ old('payment_method', 'credit_card') == 'credit_card' ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-medium text-gray-900">Kredi Kartı</span>
                                            <div class="flex gap-1">
                                                <svg class="h-6 w-10" viewBox="0 0 40 24" fill="none">
                                                    <rect width="40" height="24" rx="4" fill="#EB001B"/>
                                                    <circle cx="15" cy="12" r="7" fill="#F79E1B"/>
                                                    <circle cx="25" cy="12" r="7" fill="#FF5F00"/>
                                                </svg>
                                                <svg class="h-6 w-10" viewBox="0 0 40 24" fill="none">
                                                    <rect width="40" height="24" rx="4" fill="#0066B2"/>
                                                    <path d="M13 8h14v8H13z" fill="#FCD116"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="payment_method" value="bank_transfer"
                                           {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                    <div class="ml-3">
                                        <span class="font-medium text-gray-900">Banka Havalesi / EFT</span>
                                        <p class="text-sm text-gray-500">Sipariş sonrası hesap bilgilerimizi göndereceğiz</p>
                                    </div>
                                </label>

                                <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="payment_method" value="cash_on_delivery"
                                           {{ old('payment_method') == 'cash_on_delivery' ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                    <div class="ml-3">
                                        <span class="font-medium text-gray-900">Kapıda Ödeme</span>
                                        <p class="text-sm text-gray-500">Ürün tesliminde nakit veya kart ile ödeme</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Not -->
                        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Sipariş Notu (Opsiyonel)</h3>
                            <textarea name="notes" id="notes" rows="3" placeholder="Siparişiniz hakkında not ekleyin..."
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Sipariş Butonu -->
                        <button type="submit" 
                                class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-4 px-6 rounded-lg transition">
                            Siparişi Onayla ve Tamamla
                        </button>
                    </form>
                </div>

                <!-- Sağ Taraf - Sipariş Özeti -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Sipariş Özeti</h3>
                        
                        <!-- Ürünler -->
                        <div class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                            @foreach($cart as $id => $item)
                                <div class="flex gap-3">
                                    <div class="flex-shrink-0 w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $item['name'] }}</p>
                                        <p class="text-sm text-gray-500">{{ $item['quantity'] }} x ₺{{ number_format($item['price'], 2) }}</p>
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">
                                        ₺{{ number_format($item['price'] * $item['quantity'], 2) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-200 pt-4 space-y-2">
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Ara Toplam</span>
                                <span>₺{{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>KDV (%20)</span>
                                <span>₺{{ number_format($total * 0.20, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Kargo</span>
                                <span>₺50.00</span>
                            </div>
                            <div class="border-t border-gray-200 pt-2 mt-2">
                                <div class="flex justify-between text-lg font-bold text-gray-900">
                                    <span>Toplam</span>
                                    <span>₺{{ number_format($total + ($total * 0.20) + 50, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Güven İkonları -->
                        <div class="mt-6 pt-6 border-t border-gray-200 space-y-2">
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Güvenli Ödeme</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"></path>
                                </svg>
                                <span>Hızlı Kargo</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                </svg>
                                <span>14 Gün İade</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>