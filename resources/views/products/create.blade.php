@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <h1 class="text-2xl font-bold mb-6">Добавить новый товар</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('products.store') }}" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Название товара</label>
                <input type="text" name="name" id="name" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Описание</label>
                <textarea name="description" id="description" rows="3" required
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
            </div>
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Цена</label>
                <input type="number" step="0.01" name="price" id="price" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Создать товар
            </button>
        </form>
    </div>
@endsection