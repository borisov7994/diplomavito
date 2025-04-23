@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold text-center text-white dark:text-gray-800 mb-12">Мои товары</h1>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($products as $product)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 animate-fade-in">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-50 mb-3">{{ $product->name }}</h3>
                        <p class="text-gray-700 dark:text-gray-200 mb-4 line-clamp-3">{{ $product->description }}</p>
                        
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-xl font-bold text-gray-900 dark:text-gray-50">
                                {{ number_format($product->price, 2) }} ₽
                            </span>
                            <div class="flex space-x-2">
                                <form action="{{ route('products.destroy', $product) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-100 dark:hover:bg-red-900 rounded">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
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
                @endforeach
            </div>
        </div>
    </div>
@endsection