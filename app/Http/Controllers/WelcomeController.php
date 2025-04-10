<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $products = Product::with('user')->latest()->get();
        return view('welcome', compact('products'));
    }
}
