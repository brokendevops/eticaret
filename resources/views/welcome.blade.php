<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Ticaret - Online Alışverişin Adresi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <!-- Navigation -->
    @include('layouts.navigation')

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-5xl font-bold mb-6">Online Alışverişin Yeni Adresi</h1>
                <p class="text-xl mb-8 text-blue-100">En kaliteli ürünler, en uygun fiyatlar, hızlı teslimat!</p>
                <div class="flex justify-center gap-4">
                    <a href="{{ route('products.index') }}" class="bg-white text-blue-600 font-bold py-3 px-8 rounded-lg hover:bg-gray-100 transition">
                        Ürünleri İncele
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="bg-blue-800 text-white font-bold py-3 px-8 rounded-lg hover:bg-blue-900 transition">
                            Ücretsiz Üye Ol
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    <!-- Özellikler -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Neden Bizi Tercih Etmelisiniz?</h2>
                <p class="text-gray-600">Müşteri memnuniyeti odaklı hizmet anlayışımız</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Güvenli Alışveriş</h3>
                    <p class="text-gray-600 text-sm">256-bit SSL güvenlik sertifikası</p>
                </div>

                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Güvenli Ödeme</h3>
                    <p class="text-gray-600 text-sm">Tüm kredi kartları kabul edilir</p>
                </div>

                <div class="text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Hızlı Kargo</h3>
                    <p class="text-gray-600 text-sm">500 TL üzeri ücretsiz kargo</p>
                </div>

                <div class="text-center">
                    <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">14 Gün İade</h3>
                    <p class="text-gray-600 text-sm">Koşulsuz iade garantisi</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Öne Çıkan Ürünler -->
    <div class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Öne Çıkan Ürünler</h2>
                <p class="text-gray-600">En popüler ve çok satan ürünlerimiz</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                @php
                    $featuredProducts = \App\Models\Product::where('is_featured', true)
                        ->where('is_active', true)
                        ->limit(4)
                        ->get();
                @endphp

                @foreach($featuredProducts as $product)
                    <div class="bg-white rounded-lg shadow-sm hover:shadow-lg transition overflow-hidden">
                        <div class="h-48 overflow-hidden bg-gray-100">
                            <img src="{{ $product->getImageUrl(400, 300) }}" 
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-contain">
                        </div>
                        <div class="p-4">
                            <p class="text-xs text-gray-500 mb-1">{{ $product->category->name }}</p>
                            <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 h-12">{{ $product->name }}</h3>
                            <div class="flex items-center justify-between">
                                <div>
                                    @if($product->sale_price)
                                        <p class="text-lg font-bold text-red-600">₺{{ number_format($product->sale_price, 2) }}</p>
                                        <p class="text-sm text-gray-500 line-through">₺{{ number_format($product->price, 2) }}</p>
                                    @else
                                        <p class="text-lg font-bold text-gray-900">₺{{ number_format($product->price, 2) }}</p>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('products.show', $product->slug) }}" 
                               class="mt-3 block w-full bg-blue-500 hover:bg-blue-600 text-white text-center py-2 rounded font-medium transition">
                                İncele
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center">
                <a href="{{ route('products.index') }}" class="inline-block bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 px-8 rounded-lg transition">
                    Tüm Ürünleri Gör
                </a>
            </div>
        </div>
    </div>

    <!-- Kategoriler -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Kategoriler</h2>
                <p class="text-gray-600">İhtiyacınız olan her şey bir tık uzağınızda</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @php
                    $categories = \App\Models\Category::where('is_active', true)->get();
                @endphp

                @foreach($categories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}" 
                       class="bg-white rounded-lg p-6 text-center hover:shadow-lg transition">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900">{{ $category->name }}</h3>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-blue-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Hemen Alışverişe Başlayın!</h2>
            <p class="text-xl text-blue-100 mb-8">Binlerce ürün arasından size en uygun olanı bulun</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-white text-blue-600 font-bold py-3 px-8 rounded-lg hover:bg-gray-100 transition">
                Ürünleri Keşfet
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-white font-bold text-lg mb-4">E-Ticaret</h3>
                    <p class="text-sm">Online alışverişin en güvenilir adresi. Kaliteli ürünler, uygun fiyatlar.</p>
                </div>
                
                <div>
                    <h4 class="text-white font-semibold mb-4">Hızlı Linkler</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('products.index') }}" class="hover:text-white">Ürünler</a></li>
                        @auth
                            <li><a href="{{ route('orders.index') }}" class="hover:text-white">Siparişlerim</a></li>
                        @endauth
                        <li><a href="{{ route('cart.index') }}" class="hover:text-white">Sepetim</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white font-semibold mb-4">Müşteri Hizmetleri</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">İletişim</a></li>
                        <li><a href="#" class="hover:text-white">SSS</a></li>
                        <li><a href="#" class="hover:text-white">Kargo & Teslimat</a></li>
                        <li><a href="#" class="hover:text-white">İade & Değişim</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white font-semibold mb-4">Bizi Takip Edin</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
                <p>&copy; {{ date('Y') }} E-Ticaret. Tüm hakları saklıdır.</p>
            </div>
        </div>
    </footer>
</body>
</html>