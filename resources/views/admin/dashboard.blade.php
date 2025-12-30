<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- İstatistik Kartları -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Toplam Siparişler -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <p class="text-sm text-gray-500">Toplam Siparişler</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $totalOrders }}</p>
                            </div>
                            <div class="text-blue-500">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="text-sm text-orange-500">{{ $pendingOrders }} beklemede</span>
                        </div>
                    </div>
                </div>

                <!-- Toplam Gelir -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <p class="text-sm text-gray-500">Toplam Gelir</p>
                                <p class="text-3xl font-bold text-gray-900">₺{{ number_format($totalRevenue, 2) }}</p>
                            </div>
                            <div class="text-green-500">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Toplam Ürünler -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <p class="text-sm text-gray-500">Toplam Ürünler</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $totalProducts }}</p>
                            </div>
                            <div class="text-purple-500">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="text-sm text-red-500">{{ $lowStockProducts }} düşük stoklu</span>
                        </div>
                    </div>
                </div>

                <!-- Toplam Kullanıcılar -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <p class="text-sm text-gray-500">Toplam Müşteriler</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $totalUsers }}</p>
                            </div>
                            <div class="text-indigo-500">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Son Siparişler ve Düşük Stok -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Son Siparişler -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Son Siparişler</h3>
                        <div class="space-y-3">
                            @forelse($recentOrders as $order)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $order->order_number }}</p>
                                        <p class="text-sm text-gray-500">{{ $order->user->name }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium text-gray-900">₺{{ number_format($order->total, 2) }}</p>
                                        <span class="inline-flex px-2 py-1 text-xs rounded-full 
                                            @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                            @elseif($order->status == 'delivered') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">Henüz sipariş yok</p>
                            @endforelse
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Tüm siparişleri gör →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Düşük Stoklu Ürünler -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Düşük Stoklu Ürünler</h3>
                        <div class="space-y-3">
                            @forelse($lowStock as $product)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $product->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                            Stok: {{ $product->stock }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">Düşük stoklu ürün yok</p>
                            @endforelse
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Tüm ürünleri gör →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hızlı Linkler -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('admin.products.create') }}" class="block p-6 bg-white border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 transition">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <p class="mt-2 text-sm font-medium text-gray-900">Yeni Ürün Ekle</p>
                    </div>
                </a>

                <a href="{{ route('admin.orders.index') }}" class="block p-6 bg-white border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 transition">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <p class="mt-2 text-sm font-medium text-gray-900">Siparişleri Yönet</p>
                    </div>
                </a>

                <a href="{{ route('admin.products.index') }}" class="block p-6 bg-white border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 transition">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <p class="mt-2 text-sm font-medium text-gray-900">Ürünleri Yönet</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-admin-layout>