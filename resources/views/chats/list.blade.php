@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold mb-6">Мои чаты</h1>
    
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow divide-y divide-gray-200 dark:divide-gray-700">
        @foreach($chats as $chat)
        <a href="{{ route('chats.show', $chat->id) }}" class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-primary-100 dark:bg-gray-600 flex items-center justify-center">
                        <span class="text-sm font-medium">
                            {{ $chat->seller && $chat->seller->name ? strtoupper(substr($chat->seller->name, 0, 1)) : '?' }}
                        </span>
                    </div>
                    <div>
                        <p class="font-medium">{{ $chat->seller->name ?? 'Unknown' }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $chat->product->name ?? 'No product' }}</p>
                    </div>
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $chat->updated_at->diffForHumans() }}
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection