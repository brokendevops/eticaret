<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sipariş Yönetimi') }}
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

            <!-- Filtreler -->
            <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Sipariş Durumu</label>
                        <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Tümü</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Beklemede</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Hazırlanıyor</option>
                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Kargoda</option>
                            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Teslim Edildi</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>İptal Edildi</option>
                        </select>
                    </div>

                    <div class="flex-1 min-w-[200px]">
                        <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-1">Ödeme Durumu</label>
                        <select name="payment_status" id="payment_status" class="w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Tümü</option>
                            <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Ödenmedi</option>
                            <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Ödendi</option>
                            <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Başarısız</option>
                            <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>İade Edildi</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-6 rounded">
                            Filtrele
                        </button>
                        @if(request('status') || request('payment_status'))
                            <a href="{{ route('admin.orders.index') }}" class="ml-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-6 rounded">
                                Temizle
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Sipariş Listesi -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sipariş No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Müşteri</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tarih</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tutar</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sipariş Durumu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ödeme Durumu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($orders as $order)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $order->order_number }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $order->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $order->created_at->format('d.m.Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            ₺{{ number_format($order->total, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
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
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
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
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.orders.show', $order) }}" 
                                               class="text-blue-600 hover:text-blue-900">
                                                Detay
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                            Sipariş bulunmamaktadır.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>

            <!-- İstatistikler -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="text-sm text-gray-500">Bekleyen Siparişler</div>
                    <div class="text-2xl font-bold text-yellow-600">
                        {{ \App\Models\Order::where('status', 'pending')->count() }}
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="text-sm text-gray-500">Hazırlanan Siparişler</div>
                    <div class="text-2xl font-bold text-blue-600">
                        {{ \App\Models\Order::where('status', 'processing')->count() }}
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="text-sm text-gray-500">Kargodaki Siparişler</div>
                    <div class="text-2xl font-bold text-purple-600">
                        {{ \App\Models\Order::where('status', 'shipped')->count() }}
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="text-sm text-gray-500">Tamamlanan Siparişler</div>
                    <div class="text-2xl font-bold text-green-600">
                        {{ \App\Models\Order::where('status', 'delivered')->count() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>