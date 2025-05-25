<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Product;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        
        $chats = Chat::with(['product', 'seller', 'buyer', 'messages'])
            ->where('seller_id', $userId)
            ->orWhere('buyer_id', $userId)
            ->latest()
            ->get();

        return view('chats.list', compact('chats'));
    }
    
    public function store(Request $request, Product $product)
    {
        $chat = Chat::firstOrCreate([
            'product_id' => $product->id,
            'seller_id' => $product->user_id,
            'buyer_id' => auth()->id()
        ]);

        return redirect()->route('chats.show', $chat);
    }
    
    
    public function show(Chat $chat)
{
    $chats = Chat::where('buyer_id', auth()->id())
        ->orWhere('seller_id', auth()->id())
        ->with(['product', 'seller', 'messages'])
        ->get();

    return view('chats.show', compact('chat', 'chats'));
}

public function storeMessage(Request $request, Chat $chat)
{
    $request->validate(['body' => 'required|string']);
    
    $message = $chat->messages()->create([
        'user_id' => auth()->id(),
        'body' => $request->body
    ]);
    
    return redirect()->back()->with('status', 'Сообщение отправлено');
}
}
