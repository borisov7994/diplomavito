@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <div class="p-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6">{{ $product->name }}</h1>
                
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <!-- Место для изображений товара -->
                        <div class="bg-gray-200 dark:bg-gray-700 rounded-lg h-64 flex items-center justify-center">
                            <span class="text-gray-500 dark:text-gray-400">Изображение товара</span>
                        </div>
                    </div>
                    
                    <div>
                        <p class="text-gray-700 dark:text-gray-300 mb-6">{{ $product->description }}</p>
                        
                        <div class="flex items-center mb-6">
                            <span class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ number_format($product->price, 2) }} ₽
                            </span>
                        </div>
                        
                        <div class="mb-8">
                            <a href="{{ route('messages.show', $product) }}" class="block bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg w-full text-center">
                                Связаться с продавцом
                            </a>
                        </div>
                        
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-primary-100 dark:bg-gray-700 flex items-center justify-center mr-3">
                                    <span class="text-sm font-medium text-primary-600 dark:text-primary-300">
                                        {{ strtoupper(substr($product->user->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <span class="block font-medium text-gray-900 dark:text-gray-100">{{ $product->user->name }}</span>
                                    <span class="block text-sm text-gray-500 dark:text-gray-400">Продавец</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection