@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-900">Добавить новый товар</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('products.store') }}" class="space-y-6" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-900 mb-1">
                    Название товара
                    <span class="text-xs text-gray-600">(Например: iPhone 13 Pro Max 256GB, Синий)</span>
                </label>
                <input type="text" name="name" id="name" required placeholder="Укажите полное название и модель"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-faceit-orange focus:ring-faceit-orange p-3 border text-gray-900">
            </div>
            
            <div>
                <label for="description" class="block text-sm font-medium text-gray-900 mb-1">
                    Описание
                    <span class="text-xs text-gray-600">(Опишите состояние, комплектацию, особенности)</span>
                </label>
                <textarea name="description" id="description" rows="5" required 
                          placeholder="Подробно опишите товар: состояние, комплектацию, дефекты если есть"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-faceit-orange focus:ring-faceit-orange p-3 border text-gray-900"></textarea>
            </div>
            
            <div>
                <label for="price" class="block text-sm font-medium text-gray-900 mb-1">
                    Цена
                    <span class="text-xs text-gray-600">(Укажите цену в рублях)</span>
                </label>
                <input type="number" step="0.01" name="price" id="price" required placeholder="Например: 59990"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-faceit-orange focus:ring-faceit-orange p-3 border text-gray-900">
            </div>
            
            <div>
                <label for="image" class="block text-sm font-medium text-gray-900 mb-1">
                    Фото товара
                    <span class="text-xs text-gray-600">(Добавьте четкие фото со всех сторон)</span>
                </label>
                <input type="file" name="image" id="image" class="mt-1 block w-full file:mr-4 file:py-2 file:px-4
                      file:rounded-md file:border-0 file:text-sm file:font-semibold
                      file:bg-faceit-orange file:text-white hover:file:bg-orange-600" 
                      accept="image/*">
            </div>
            
            <button type="submit" class="w-full px-6 py-3 bg-faceit-orange text-white font-medium rounded-lg 
                   shadow-md hover:bg-orange-600 transition duration-300 focus:outline-none focus:ring-2 
                   focus:ring-faceit-orange focus:ring-opacity-50">
                Создать товар
            </button>
        </form>
    </div>
@endsection
