@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Список чатов -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <h3 class="text-xl font-bold mb-4 text-orange-600 dark:text-orange-400">Мои чаты</h3>
            <div class="space-y-2">
                @foreach($chats as $chatItem)
                <a href="{{ route('chats.show', $chatItem) }}" 
                   class="block p-3 rounded-lg transition-all duration-300 ease-in-out 
                          hover:bg-orange-50 dark:hover:bg-orange-900/30 hover:shadow-md
                          @if($chat->id == $chatItem->id) bg-orange-100 dark:bg-orange-900 border-l-4 border-orange-500 @endif">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-orange-500 flex items-center justify-center mr-3 
                             transition-transform duration-300 hover:scale-110">
                            <span class="text-sm font-medium text-white">
                                {{ strtoupper(substr($chatItem->seller->name, 0, 1)) }}
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-orange-600 dark:text-orange-400">{{ $chatItem->seller->name }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300 truncate transition-colors duration-300 group-hover:text-orange-500">
                                {{ $chatItem->product->name }}
                            </p>
                        </div>
                        @if($chatItem->messages->count() > 0)
                        <div class="ml-2 bg-orange-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center animate-pulse">
                            {{ $chatItem->messages->count() }}
                        </div>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Окно чата -->
        <div class="md:col-span-3">
            <div class="bg-faceit-light dark:bg-faceit-dark rounded-xl shadow-lg p-6">
                <!-- Заголовок чата -->
                <div class="flex justify-between items-center mb-6 pb-4 border-b border-faceit-orange/20">
                    <div class="flex-1">
                        <h2 class="text-xl font-bold text-faceit-dark dark:text-faceit-light">
                            {{ $chat->product->name }}
                        </h2>
                    </div>
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-faceit-orange/10 flex items-center justify-center mr-3">
                            <span class="text-sm font-medium text-faceit-orange">
                                {{ strtoupper(substr($chat->seller->name, 0, 1)) }}
                            </span>
                        </div>
                        <span class="text-lg font-medium text-faceit-dark dark:text-faceit-light">
                            {{ $chat->seller->name }}
                        </span>
                    </div>
                </div>
                
                <!-- Сообщения -->
                <div class="space-y-4 mb-6 max-h-[calc(100vh-300px)] overflow-y-auto scroll-smooth" id="messages-container">
                    @foreach($chat->messages as $message)
                    <div class="flex {{ $message->user_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-xs md:max-w-md px-4 py-3 rounded-xl 
                            {{ $message->user_id == auth()->id() 
                                ? 'bg-faceit-orange text-white rounded-br-none' 
                                : 'bg-gray-200 dark:bg-gray-700 rounded-bl-none' }}">
                            <p class="break-words">{{ $message->body }}</p>
                            <div class="flex justify-between items-center mt-1">
                                <p class="text-xs {{ $message->user_id == auth()->id() ? 'text-orange-100' : 'text-gray-500 dark:text-gray-400' }}">
                                    {{ $message->created_at->format('H:i') }}
                                </p>
                                <p class="text-xs {{ $message->user_id == auth()->id() ? 'text-orange-100' : 'text-gray-500 dark:text-gray-400' }}">
                                    {{ $message->user_id == auth()->id() ? '' : $message->user->name }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Форма отправки сообщения -->
                <form action="{{ route('chats.messages.store', $chat) }}" method="POST">
                    @csrf
                    <div class="flex space-x-2 mt-4">
                        <input type="text" name="body" placeholder="Введите сообщение..." 
                               class="flex-1 rounded-lg border-gray-300 focus:border-faceit-orange focus:ring-faceit-orange dark:bg-gray-700 dark:text-gray-200">
                        <button type="submit" class="px-4 py-2 bg-faceit-orange hover:bg-orange-600 text-white rounded-lg transition duration-300 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                            </svg>
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
