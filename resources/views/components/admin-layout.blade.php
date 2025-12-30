<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Panel - {{ config('app.name', 'E-Ticaret') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white flex-shrink-0">
            <div class="h-full flex flex-col">
                
                <!-- Logo -->
                <div class="p-6 border-b border-gray-800">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                        <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span class="ml-3 text-xl font-bold">Admin Panel</span>
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                    
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition
                              {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>

                    <!-- Ürünler -->
                    <div class="space-y-1">
                        <div class="flex items-center px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Ürün Yönetimi
                        </div>
                        
                        <a href="{{ route('admin.products.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg transition
                                  {{ request()->routeIs('admin.products.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Ürünler
                            <span class="ml-auto bg-gray-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Product::count() }}
                            </span>
                        </a>

                        <a href="{{ route('admin.products.create') }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800 transition">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Yeni Ürün Ekle
                        </a>
                    </div>

                    <!-- Siparişler -->
                    <div class="space-y-1">
                        <div class="flex items-center px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Sipariş Yönetimi
                        </div>
                        
                        <a href="{{ route('admin.orders.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg transition
                                  {{ request()->routeIs('admin.orders.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Tüm Siparişler
                            <span class="ml-auto bg-gray-800 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Order::count() }}
                            </span>
                        </a>

                        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800 transition">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Bekleyen Siparişler
                            <span class="ml-auto bg-yellow-500 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Order::where('status', 'pending')->count() }}
                            </span>
                        </a>
                    </div>

                </nav>

                <!-- User Info & Logout -->
                <div class="p-4 border-t border-gray-800">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center">
                            <span class="text-white font-bold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-400">Admin</p>
                        </div>
                    </div>
                    
                    <div class="space-y-1">
                        <a href="{{ route('products.index') }}" 
                           class="flex items-center px-4 py-2 rounded-lg text-gray-300 hover:bg-gray-800 transition text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Siteyi Görüntüle
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full flex items-center px-4 py-2 rounded-lg text-gray-300 hover:bg-gray-800 transition text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Çıkış Yap
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Top Bar -->
            <header class="bg-white shadow-sm">
                <div class="px-6 py-4">
                    @if (isset($header))
                        <div class="font-semibold text-xl text-gray-800">
                            {{ $header }}
                        </div>
                    @endif
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto">
                {{ $slot }}
            </main>

        </div>
    </div>
</body>
</html>