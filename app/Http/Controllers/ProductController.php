<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('user')
            ->latest()
            ->paginate(12);
        
        // Исправлено с welcome на dashboard
        return view('dashboard', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048' // Убедитесь, что стоит nullable
        ]);
    
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('product_images', 'public');
        } else {
            $validated['image'] = null; // Явное присвоение NULL
        }
    
        $validated['user_id'] = auth()->id();
        Product::create($validated);
        
        return redirect()->route('products.index')->with('success', 'Товар успешно создан');
    }
    public function destroy(Product $product) {
        $product->delete();
        return redirect()->back();
    }

    public function show(Product $product) 
    {
    return view('products.show', compact('product'));
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        if(empty($query)) {
            $products = Product::with('user')->latest()->paginate(12);
        } else {
            $products = Product::where('name', 'like', '%'.$query.'%')
                ->with('user')
                ->paginate(12);
        }
        
        return response()->json([
            'html' => view('products.partials.grid', compact('products'))->render()
        ]);
    }
}
