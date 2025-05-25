@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Список чатов -->
        <div class="bg-faceit-light dark:bg-faceit-dark rounded-lg shadow-lg p-4 border border-faceit-orange/20">
            <h3 class="text-xl font-bold mb-4 text-faceit-dark dark:text-faceit-light">Мои чаты</h3>
            <div class="space-y-2 max-h-[calc(100vh-200px)] overflow-y-auto">
                @foreach($chats as $chat)
                <a href="{{ route('chats.show', $chat) }}" 
                   class="block p-3 rounded-lg hover:bg-faceit-orange/10 dark:hover:bg-faceit-orange/20 transition duration-300 border-b border-faceit-orange/10 last:border-0">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-faceit-orange/10 flex items-center justify-center mr-3">
                            <span class="text-sm font-medium text-faceit-orange">
                                {{ $chat->seller && $chat->seller->name ? strtoupper(substr($chat->seller->name, 0, 1)) : '?' }}
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-faceit-dark dark:text-faceit-light">{{ $chat->seller->name ?? 'Unknown' }}</p>
                            <p class="text-sm text-faceit-dark/70 dark:text-faceit-light/70 truncate">{{ $chat->product->name ?? 'No product' }}</p>
                            @if($chat->messages->count() > 0)
                            <p class="text-xs text-faceit-dark/50 dark:text-faceit-light/50 truncate">
                                {{ Str::limit($chat->messages->last()->content, 30) }}
                            </p>
                            @endif
                        </div>
                        @if($chat->unread_count > 0)
                        <span class="ml-2 w-5 h-5 bg-faceit-orange text-white text-xs rounded-full flex items-center justify-center">
                            {{ $chat->unread_count }}
                        </span>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Окно чата -->
        <div class="md:col-span-3">
            @isset($selectedChat)
            <div class="bg-faceit-light dark:bg-faceit-dark rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold mb-6 text-faceit-dark dark:text-faceit-light">
                    Чат с {{ $chat->seller->name }}
                </h2>
                <div class="space-y-4">
                    @foreach($messages as $message)
                    <div class="flex {{ $message->user_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-xs md:max-w-md px-4 py-2 rounded-lg {{ $message->user_id == auth()->id() ? 'bg-faceit-orange text-white' : 'bg-gray-200 dark:bg-gray-700' }}">
                            <p>{{ $message->body }}</p>
                            <p class="text-xs {{ $message->user_id == auth()->id() ? 'text-orange-100' : 'text-gray-500 dark:text-gray-400' }}">
                                {{ $message->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <form action="{{ route('chats.messages.store', $selectedChat) }}" method="POST">
                    @csrf
                    <div class="flex space-x-2">
                        <input type="text" name="content" placeholder="Введите сообщение..." 
                               class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                            Отправить
                        </button>
                    </div>
                </form>
            </div>
            @else
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex items-center justify-center h-full">
                <p class="text-gray-500 dark:text-gray-400">Выберите чат для просмотра сообщений</p>
            </div>
            @endisset
        </div>
    </div>
</div>
@endsection