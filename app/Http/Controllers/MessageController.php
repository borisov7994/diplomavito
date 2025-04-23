<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Message;
use App\Models\Product;
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
        $request->validate([
            'content' => 'required|string|max:1000',
            'recipient_id' => 'required|exists:users,id'
        ]);
    
        $message = Message::create([
            'content' => $request->content,
            'sender_id' => auth()->id(),
            'recipient_id' => $request->recipient_id,
            'product_id' => $product->id,
        ]);
    
        if($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
    
        return redirect()->route('messages.index', $product);
    }

    public function list()
    {
        $conversations = $this->getConversations();
        return view('messages.list', compact('conversations'));
    }

    public function show(Product $product)
    {
        $messages = Message::where('product_id', $product->id)
            ->where(function($query) {
                $query->where('sender_id', auth()->id())
                    ->orWhere('recipient_id', auth()->id());
            })
            ->with(['sender', 'recipient'])
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
        ->groupBy('product_id')
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

