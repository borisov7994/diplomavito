<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Получаем товары текущего пользователя
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
            'name' => 'required|string|max:255', // Убедитесь, что имя поля совпадает с формой
            'description' => 'required|string',
            'price' => 'required|numeric|min:0'
        ]);
        
        // Создаем товар
        auth()->user()->products()->create($validated);
        
        return redirect()->route('dashboard')->with('success', 'Товар успешно добавлен!');
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