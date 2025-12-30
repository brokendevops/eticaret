<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ödeme') }} - {{ $order->order_number }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Güvenlik Bildirimi -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            <strong>Demo Ödeme Sistemi:</strong> Bu bir test ortamıdır. Gerçek kredi kartı bilgilerinizi kullanmayın. Herhangi bir kart numarası ile ödeme yapabilirsiniz.
                        </p>
                    </div>
                </div>
            </div>

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
                
                <!-- Sol Taraf - Ödeme Formu -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Kredi Kartı Bilgileri</h3>
                        
                        <form action="{{ route('orders.processPayment', $order) }}" method="POST" id="paymentForm">
                            @csrf
                            
                            <!-- Kart Numarası -->
                            <div class="mb-4">
                                <label for="card_number" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kart Numarası <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           name="card_number" 
                                           id="card_number" 
                                           placeholder="1234 5678 9012 3456"
                                           maxlength="16"
                                           required
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pl-10">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Demo için: 4242424242424242 kullanabilirsiniz</p>
                            </div>

                            <!-- Kart Üzerindeki İsim -->
                            <div class="mb-4">
                                <label for="card_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kart Üzerindeki İsim <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="card_name" 
                                       id="card_name" 
                                       placeholder="AD SOYAD"
                                       required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Son Kullanma Tarihi ve CVV -->
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label for="card_expiry" class="block text-sm font-medium text-gray-700 mb-2">
                                        Son Kullanma Tarihi <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="card_expiry" 
                                           id="card_expiry" 
                                           placeholder="MM/YY"
                                           maxlength="5"
                                           required
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <p class="mt-1 text-xs text-gray-500">Demo için: 12/25</p>
                                </div>

                                <div>
                                    <label for="card_cvv" class="block text-sm font-medium text-gray-700 mb-2">
                                        CVV <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="card_cvv" 
                                           id="card_cvv" 
                                           placeholder="123"
                                           maxlength="3"
                                           required
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <p class="mt-1 text-xs text-gray-500">Demo için: 123</p>
                                </div>
                            </div>

                            <!-- Güvenlik İkonları -->
                            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                <div class="flex items-center justify-center space-x-4">
                                    <svg class="h-8 w-12" viewBox="0 0 40 24" fill="none">
                                        <rect width="40" height="24" rx="4" fill="#1434CB"/>
                                        <path d="M13 8h14v8H13z" fill="white"/>
                                    </svg>
                                    <svg class="h-8 w-12" viewBox="0 0 40 24" fill="none">
                                        <rect width="40" height="24" rx="4" fill="#EB001B"/>
                                        <circle cx="15" cy="12" r="7" fill="#F79E1B"/>
                                        <circle cx="25" cy="12" r="7" fill="#FF5F00"/>
                                    </svg>
                                    <svg class="h-8 w-12" viewBox="0 0 40 24" fill="none">
                                        <rect width="40" height="24" rx="4" fill="#016FD0"/>
                                    </svg>
                                </div>
                                <p class="text-center text-xs text-gray-600 mt-2">
                                    256-bit SSL şifreleme ile güvenli ödeme
                                </p>
                            </div>

                            <!-- Ödeme Butonu -->
                            <button type="submit" 
                                    class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-4 px-6 rounded-lg transition flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                ₺{{ number_format($order->total, 2) }} Öde
                            </button>

                            <p class="text-center text-xs text-gray-500 mt-4">
                                Ödeme butonuna tıklayarak <a href="#" class="text-blue-600 hover:underline">kullanım koşullarını</a> kabul etmiş olursunuz.
                            </p>
                        </form>
                    </div>
                </div>

                <!-- Sağ Taraf - Sipariş Özeti -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Sipariş Özeti</h3>
                        
                        <!-- Ürünler -->
                        <div class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                            @foreach($order->orderItems as $item)
                                <div class="flex gap-3">
                                    <div class="flex-shrink-0 w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $item->product_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->quantity }} x ₺{{ number_format($item->price, 2) }}</p>
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">
                                        ₺{{ number_format($item->total, 2) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-200 pt-4 space-y-2">
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Ara Toplam</span>
                                <span>₺{{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>KDV (%20)</span>
                                <span>₺{{ number_format($order->tax, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Kargo</span>
                                <span>₺{{ number_format($order->shipping, 2) }}</span>
                            </div>
                            <div class="border-t border-gray-200 pt-2 mt-2">
                                <div class="flex justify-between text-lg font-bold text-gray-900">
                                    <span>Toplam</span>
                                    <span>₺{{ number_format($order->total, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Teslimat Adresi -->
                        <div class="border-t border-gray-200 mt-4 pt-4">
                            <p class="text-xs font-medium text-gray-500 mb-2">Teslimat Adresi</p>
                            <p class="text-sm text-gray-600">
                                {{ $order->shipping_address }}, {{ $order->shipping_city }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Kart numarası formatı
        document.getElementById('card_number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value.substring(0, 16);
        });

        // Son kullanma tarihi formatı
        document.getElementById('card_expiry').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            e.target.value = value;
        });

        // CVV formatı
        document.getElementById('card_cvv').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value.substring(0, 3);
        });
    </script>
</x-app-layout>