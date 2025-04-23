@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Список чатов -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">Мои чаты</h3>
            <div class="space-y-2">
                @foreach($conversations as $conversation)
                <a href="{{ route('messages.show', $conversation['product']) }}" 
                   class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition
                          @if($product->id == $conversation['product']->id) bg-blue-50 dark:bg-blue-900 @endif">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-primary-100 dark:bg-gray-700 flex items-center justify-center mr-3">
                            <span class="text-sm font-medium text-primary-600 dark:text-primary-300">
                                {{ strtoupper(substr($conversation['user']->name, 0, 1)) }}
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $conversation['user']->name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $conversation['product']->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                {{ Str::limit($conversation['last_message']->content, 30) }}
                            </p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Окно чата -->
        <div class="md:col-span-3">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">
                    Чат с {{ $product->user->name }} по товару: {{ $product->name }}
                </h2>
                
                <div class="space-y-4 mb-6 max-h-96 overflow-y-auto">
                    @foreach($messages as $message)
                    <div class="@if($message->sender_id == auth()->id()) text-right @endif">
                        <div class="@if($message->sender_id == auth()->id()) bg-blue-100 dark:bg-blue-900 @else bg-gray-100 dark:bg-gray-700 @endif rounded-lg p-4 inline-block max-w-xs">
                            <p class="text-gray-800 dark:text-gray-200">{{ $message->content }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                {{ $message->created_at->diffForHumans() }} | 
                                {{ $message->sender_id == auth()->id() ? 'Вы' : $message->sender->name }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <form action="{{ route('messages.store', $product) }}" method="POST">
                    @csrf
                    <input type="hidden" name="recipient_id" value="{{ $product->user_id }}">
                    <div class="flex space-x-2">
                        <input type="text" name="content" placeholder="Введите сообщение..." 
                               class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                            Отправить
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection