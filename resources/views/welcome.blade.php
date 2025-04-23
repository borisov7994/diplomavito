<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Marketplace</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS with custom config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            500: '#3B82F6',
                            600: '#2563EB',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
</head>
<body class="antialiased bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
    <div class="min-h-screen">
        <nav class="bg-white dark:bg-gray-800 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="shrink-0 flex items-center">
                            <a href="{{ url('/') }}">
                                <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                            </a>
                        </div>
                    </div>

                    @if (Route::has('login'))
                        <div class="flex items-center">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded-md font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300 transition-colors">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="px-4 py-2 rounded-md font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300 transition-colors">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="ml-4 px-4 py-2 bg-primary-500 text-white rounded-md font-medium hover:bg-primary-600 transition-colors">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <h1 class="text-4xl font-bold text-center text-gray-900 dark:text-gray-300 mb-12">Featured Products</h1>
            
            <!-- Products Grid -->
            <div class="mt-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($products as $product)
                    <a href="{{ route('products.show', $product) }}" class="block">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 animate-fade-in">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">{{ $product->name }}</h3>
                                <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">{{ $product->description }}</p>
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-xl font-bold text-primary-500 dark:text-primary-400">
                                        {{ number_format($product->price, 2) }} ₽
                                    </span>
                                </div>
                                <div class="flex items-center pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <div class="w-8 h-8 rounded-full bg-primary-100 dark:bg-gray-700 flex items-center justify-center mr-3">
                                        <span class="text-sm font-medium text-primary-600 dark:text-primary-300">
                                            {{ strtoupper(substr($product->user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                        {{ $product->user->name }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</body>
</html>