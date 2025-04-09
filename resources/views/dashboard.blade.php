@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($products as $product)
                    <div class="overflow-hidden bg-white rounded-lg shadow">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900">{{ $product->name }}</h3>
                            <p class="mt-2 text-gray-600">{{ $product->description }}</p>
                            <div class="flex items-center justify-between mt-4">
                                <span class="text-xl font-bold text-indigo-600">
                                    {{ number_format($product->price, 2) }} ₽
                                </span>
                                <div class="flex space-x-2">
                                    <a href="#" class="p-2 text-blue-500 hover:bg-blue-50 rounded">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
        </div>
    </div>
    @endsection