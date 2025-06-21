<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = Product::with(['variants' => function ($query) {
            $query->whereNotNull('image')->orderBy('created_at', 'asc');
        }])
        ->orderBy('created_at', 'desc')
        ->take(8)
        ->get();

        $categories = Category::whereNull('parent_id')->orderBy('name')->take(4)->get();
        
        return view('welcome', compact('products', 'categories'));
    }
}
