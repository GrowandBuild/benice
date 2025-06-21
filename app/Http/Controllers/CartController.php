<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Exibe os itens do carrinho de compras.
     */
    public function index()
    {
        $cart = Cart::with('items.variant.product')->where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->isEmpty()) {
            return view('cart.index', ['cartItems' => collect()]);
        }

        return view('cart.index', ['cartItems' => $cart->items]);
    }

    /**
     * Adiciona uma variação de produto ao carrinho.
     */
    public function add(Request $request)
    {
        $validated = $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $variant = ProductVariant::with('product')->findOrFail($validated['variant_id']);
        
        // Verifica se há estoque suficiente
        if ($variant->stock < $validated['quantity']) {
            return back()->with('error', 'Desculpe, não há estoque suficiente para este produto.');
        }

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        // Verifica se a variação já está no carrinho
        $cartItem = $cart->items()->where('product_variant_id', $variant->id)->first();

        if ($cartItem) {
            // Se já existe, atualiza a quantidade
            $newQuantity = $cartItem->quantity + $validated['quantity'];
            if ($variant->stock < $newQuantity) {
                return back()->with('error', 'Você já tem este item no carrinho e não há estoque para adicionar mais.');
            }
            $cartItem->increment('quantity', $validated['quantity']);
        } else {
            // Se não existe, cria um novo item no carrinho
            $cart->items()->create([
                'product_id' => $variant->product_id,
                'product_variant_id' => $variant->id,
                'quantity' => $validated['quantity'],
                'price' => $variant->price, // Armazena o preço no momento da adição
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produto adicionado ao carrinho com sucesso!');
    }

    /**
     * Atualiza a quantidade de um item no carrinho.
     */
    public function update(Request $request, CartItem $cartItem)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($cartItem->variant && $cartItem->variant->stock < $validated['quantity']) {
            return back()->with('error', 'Desculpe, não há estoque suficiente para a quantidade solicitada.');
        }

        $cartItem->update(['quantity' => $validated['quantity']]);

        return redirect()->route('cart.index')->with('success', 'Carrinho atualizado.');
    }

    /**
     * Remove um item do carrinho.
     */
    public function remove(CartItem $cartItem)
    {
        $cartItem->delete();
        return redirect()->route('cart.index')->with('success', 'Item removido do carrinho.');
    }

    /**
     * Get cart count for header
     */
    public function getCount()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        
        if (!$cart) {
            return 0;
        }

        return $cart->items()->sum('quantity');
    }
}
