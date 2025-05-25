<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Models\Product;
use App\Models\Chat; // Добавляем эту строку
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Product $product)
    {
        $conversations = $this->getConversations();
    
        $messages = Message::where('product_id', $product->id)
            ->where(function($query) {
                $query->where('sender_id', auth()->id())
                    ->orWhere('recipient_id', auth()->id());
            })
            ->with(['sender', 'recipient'])
            ->orderBy('created_at', 'asc')
            ->get();
    
        return view('messages.index', compact('product', 'messages', 'conversations'));
    }

    public function store(Request $request, Product $product)
    {
        $request->merge(['recipient_id' => $product->user_id]);
        $request->validate([
            'content' => 'required|string|max:500',
            'recipient_id' => 'required|exists:users,id'
        ]);
    
        // Проверка существования чата
        $existingChat = Message::where('product_id', $product->id)
            ->where(function($query) use ($request) {
                $query->where('sender_id', auth()->id())
                      ->where('recipient_id', $request->recipient_id);
            })
            ->orWhere(function($query) use ($request) {
                $query->where('sender_id', $request->recipient_id)
                      ->where('recipient_id', auth()->id());
            })
            ->exists();
    
        // Если чата нет - создаем новый
        if (!$existingChat) {
            $message = Message::create([
                'sender_id' => auth()->id(),
                'recipient_id' => $request->recipient_id,
                'product_id' => $product->id,
                'content' => $request->content
            ]);
            
            return redirect()->route('messages.show', $product)
                   ->with('status', 'new-chat-created');
        }
    
        // Если чат уже существует - просто добавляем сообщение
        $message = Message::create([
            'sender_id' => auth()->id(),
            'recipient_id' => $request->recipient_id,
            'product_id' => $product->id,
            'content' => $request->content
        ]);
    
        return redirect()->route('messages.show', $product);
    }


    public function show(Product $product)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        if (!$product) {
            abort(404);
        }

        // Всегда показываем чат, даже если он пустой
        $chat = Chat::where('product_id', $product->id)
            ->where(function($query) {
                $query->where('seller_id', auth()->id())
                    ->orWhere('buyer_id', auth()->id());
            })
            ->firstOrFail();
    
        $messages = Message::where('chat_id', $chat->id)
            ->with(['sender'])
            ->orderBy('created_at', 'asc')
            ->get();

        $conversations = $this->getConversations();
        
        return view('messages.show', compact('product', 'messages', 'conversations'));
    }

    private function getConversations()
    {
        return Message::where(function($query) {
            $query->where('sender_id', auth()->id())
                ->orWhere('recipient_id', auth()->id());
        })
        ->with(['sender', 'recipient', 'product'])
        ->latest()
        ->get()
        ->groupBy(function ($message) {
            // Группируем по product_id и паре участников чата
            $participants = [$message->sender_id, $message->recipient_id];
            sort($participants);
            return $message->product_id . '-' . implode('-', $participants);
        })
        ->filter(function ($messages) {
            // Фильтруем только чаты текущего пользователя
            $currentUserId = auth()->id();
            $firstMessage = $messages->first();
            return $firstMessage->sender_id == $currentUserId || 
                   $firstMessage->recipient_id == $currentUserId;
        })
        ->map(function ($messages) {
            return [
                'user' => $messages->first()->sender_id == auth()->id() 
                    ? $messages->first()->recipient 
                    : $messages->first()->sender,
                'product' => $messages->first()->product,
                'last_message' => $messages->first()
            ];
        });
    }
};

