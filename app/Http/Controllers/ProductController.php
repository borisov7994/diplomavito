<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = auth()->user()->products()->latest()->get();

        return view('dashboard', [
            'products' => $products
        ]);
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
}
