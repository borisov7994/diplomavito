@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold mb-6 text-faceit-dark dark:text-faceit-light">Мои чаты</h1>
    
    <div class="bg-faceit-light dark:bg-faceit-dark rounded-xl shadow-lg border border-faceit-orange/20">
        @foreach($chats as $chat)
        <a href="{{ route('chats.show', $chat->id) }}" 
           class="block p-4 hover:bg-faceit-orange/10 dark:hover:bg-faceit-orange/20 transition duration-300 border-b border-faceit-orange/10 last:border-0">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-faceit-orange/10 flex items-center justify-center mr-3">
                        <span class="text-sm font-medium text-faceit-orange">
                            {{ $chat->seller && $chat->seller->name ? strtoupper(substr($chat->seller->name, 0, 1)) : '?' }}
                        </span>
                    </div>
                    <div>
                        <p class="font-medium text-faceit-dark dark:text-faceit-light">{{ $chat->seller->name ?? 'Unknown' }}</p>
                        <p class="text-sm text-faceit-dark/70 dark:text-faceit-light/70">{{ $chat->product->name ?? 'No product' }}</p>
                    </div>
                </div>
                <div class="flex items-center">
                    @if($chat->unread_count > 0)
                    <span class="mr-3 w-5 h-5 bg-faceit-orange text-white text-xs rounded-full flex items-center justify-center">
                        {{ $chat->unread_count }}
                    </span>
                    @endif
                    <span class="text-sm text-faceit-dark/50 dark:text-faceit-light/50">
                        {{ $chat->updated_at->diffForHumans() }}
                    </span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection