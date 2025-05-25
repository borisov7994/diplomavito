@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <div class="p-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6">{{ $product->name }}</h1>
                
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <div class="mb-4">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Фото товара">
                            @else
                                <div class="bg-gray-200 w-full h-64 flex items-center justify-center rounded">
                                    <span>Нет фото</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div>
                        <p class="text-gray-700 dark:text-gray-300 mb-6">{{ $product->description }}</p>
                        
                        <div class="flex items-center mb-6">
                            <span class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ number_format($product->price, 2) }} ₽
                            </span>
                        </div>
                        
                        <form action="{{ route('chats.store', ['product' => $product->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full md:w-auto px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 flex items-center justify-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <span>Связаться с продавцом</span>
                            </button>
                        </form>
                        
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