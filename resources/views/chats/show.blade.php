@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Список чатов -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">Мои чаты</h3>
            <div class="space-y-2">
                @foreach($chats as $chatItem)
                <a href="{{ route('chats.show', $chatItem) }}" 
                   class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition
                          @if($chat->id == $chatItem->id) bg-blue-50 dark:bg-blue-900 @endif">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-primary-100 dark:bg-gray-700 flex items-center justify-center mr-3">
                            <span class="text-sm font-medium text-primary-600 dark:text-primary-300">
                                {{ strtoupper(substr($chatItem->seller->name, 0, 1)) }}
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $chatItem->seller->name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $chatItem->product->name }}</p>
                            @if($chatItem->messages->count() > 0)
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                {{ Str::limit($chatItem->messages->last()->body, 30) }}
                            </p>
                            @endif
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
                    Чат с {{ $chat->seller->name }} по товару: {{ $chat->product->name }}
                </h2>
                
                <div class="space-y-4 mb-6 max-h-96 overflow-y-auto scroll-smooth" id="messages-container">
                    @foreach($chat->messages as $message)
                    <div class="@if($message->user_id == auth()->id()) text-right @endif">
                        <div class="@if($message->user_id == auth()->id()) bg-blue-100 dark:bg-blue-900 @else bg-gray-100 dark:bg-gray-700 @endif rounded-lg p-4 inline-block max-w-xs">
                            <p class="text-gray-800 dark:text-gray-200">{{ $message->body }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                {{ $message->created_at->diffForHumans() }} | 
                                {{ $message->user_id == auth()->id() ? 'Вы' : $message->user->name }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <form action="{{ route('chats.messages.store', $chat) }}" method="POST">
                    @csrf
                    <div class="flex space-x-2">
                        <input type="text" name="body" placeholder="Введите сообщение..." 
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

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('messages-container');
        
        function scrollToBottom() {
            container.scrollTop = container.scrollHeight;
        }
        
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            form.submit(); // Стандартная отправка формы
            
            // Scroll after short delay to allow DOM update
            setTimeout(scrollToBottom, 100);
        });
        
        // Scroll to bottom on initial load
        scrollToBottom();
    });
</script>
@endsection