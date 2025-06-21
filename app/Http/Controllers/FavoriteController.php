<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $favoriteProducts = $user->favorites;

        return view('favorites.index', compact('favoriteProducts'));
    }

    /**
     * Add a product to the user's favorites.
     */
    public function add(Product $product)
    {
        $user = Auth::user();
        if (!$user->favorites()->where('product_id', $product->id)->exists()) {
            $user->favorites()->create(['product_id' => $product->id]);
        }

        return back()->with('success', 'Produto adicionado aos favoritos!');
    }

    /**
     * Remove a product from the user's favorites.
     */
    public function remove(Product $product)
    {
        $user = Auth::user();
        $user->favorites()->where('product_id', $product->id)->delete();

        return back()->with('success', 'Produto removido dos favoritos!');
    }
}
