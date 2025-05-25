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
                        faceit: {
                            orange: '#FF5500',
                            dark: '#1E1E1E',
                            light: '#F5F5F5'
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
<body class="antialiased bg-gradient-to-br from-faceit-light to-gray-100 dark:from-faceit-dark dark:to-gray-800">
    <div class="min-h-screen">
        <nav class="bg-faceit-dark shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="shrink-0 flex items-center">
                            <a href="{{ url('/') }}">
                                <x-application-logo class="block h-9 w-auto fill-current text-faceit-orange" />
                            </a>
                        </div>
                        <div class="ml-6 flex items-center">
                        <form id="searchForm">
    <div class="relative">
        <input type="text" id="searchInput" name="query" placeholder="Поиск товаров" 
               class="bg-faceit-dark border border-faceit-orange rounded-md px-4 py-1 text-faceit-light focus:outline-none focus:ring-2 focus:ring-faceit-orange" />
        <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-faceit-orange">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </button>
    </div>
</form>
                        </div>
                    </div>

                    @if (Route::has('login'))
                        <div class="flex items-center">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded-md font-medium text-faceit-orange hover:text-orange-400 transition-colors">Профиль</a>
                            @else
                                <a href="{{ route('login') }}" class="px-4 py-2 rounded-md font-medium text-faceit-orange hover:text-orange-400 transition-colors">Войти</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="ml-4 px-4 py-2 bg-faceit-orange text-white rounded-md font-medium hover:bg-orange-600 transition-colors">Регистрация</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <h1 class="text-4xl font-bold text-center text-faceit-dark dark:text-faceit-light mb-12">Новые товары</h1>
            
            <!-- Products Grid -->
            <div class="mt-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($products as $product)
                    <a href="{{ route('products.show', $product) }}" class="block">
                        <div class="bg-faceit-light dark:bg-faceit-dark rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 animate-fade-in">
                            <!-- Product Image -->
                            <div class="h-48 bg-gray-200 overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-300">
                                        <span class="text-gray-500">No image</span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="p-4">
                                <!-- Product Name -->
                                <h3 class="text-lg font-semibold text-faceit-dark dark:text-faceit-light mb-2">{{ $product->name }}</h3>
                                
                                <!-- Seller Info -->
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 rounded-full bg-faceit-orange/10 flex items-center justify-center mr-2">
                                        <span class="text-sm font-medium text-faceit-orange">
                                            {{ strtoupper(substr($product->user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <span class="text-sm text-gray-600 dark:text-gray-300">
                                        {{ $product->user->name }}
                                    </span>
                                </div>
                                
                                <!-- Price -->
                                <div class="mt-2">
                                    <span class="text-xl font-bold text-faceit-orange">
                                        {{ number_format($product->price, 2) }} ₽
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
<script>
let searchTimer;
const route = (name) => {
    return '{{ route("products.search") }}';
};

// Обработчик ввода в поисковую строку
document.getElementById('searchInput').addEventListener('input', function() {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => {
        performSearch();
    }, 500);
});

// Обработчик кнопки поиска
document.getElementById('searchForm').addEventListener('submit', function(e) {
    e.preventDefault();
    clearTimeout(searchTimer);
    performSearch();
});

function performSearch() {
    const query = document.getElementById('searchInput').value;
    const grid = document.querySelector('.grid');
    
    if (!grid) {
        console.error('Элемент grid не найден');
        return;
    }
    
    grid.innerHTML = '<div class="col-span-full text-center py-8">Идет поиск...</div>';
    
    fetch(route('products.search') + '?query=' + encodeURIComponent(query), {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Ошибка сервера: ' + response.status);
        return response.json();
    })
    .then(data => {
        grid.innerHTML = data.html;
    })
    .catch(error => {
        grid.innerHTML = `<div class="col-span-full text-center py-8 text-red-500">${error.message}</div>`;
        console.error('Ошибка поиска:', error);
    });
}
</script>
<div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-8">
    @foreach($products as $product)
        <!-- Ваши карточки товаров -->
    @endforeach
</div>
