<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\AttributeController;
use App\Http\Controllers\Dashboard\AttributeValueController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('welcome');

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('index');
    
    Route::resource('products', \App\Http\Controllers\ProductController::class)->except(['show']);
    Route::resource('categories', \App\Http\Controllers\CategoryController::class)->except(['show']);
    Route::resource('users', \App\Http\Controllers\Dashboard\UserController::class);
    Route::resource('attributes', \App\Http\Controllers\Dashboard\AttributeController::class);
    Route::post('attributes/{attribute}/values', [AttributeValueController::class, 'store'])->name('attributes.values.store');
    Route::delete('attributes/{attribute}/values/{value}', [AttributeValueController::class, 'destroy'])->name('attributes.values.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rotas do carrinho (requer autenticação)
    Route::get('/carrinho', [CartController::class, 'index'])->name('cart.index');
    Route::post('/carrinho/adicionar', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    
    // Rotas do checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    
    // Rotas dos pedidos
    Route::get('/pedidos', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pedidos/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Rotas de Favoritos
    Route::get('/favoritos', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favoritos/adicionar/{product}', [FavoriteController::class, 'add'])->name('favorites.add');
    Route::delete('/favoritos/{product}', [FavoriteController::class, 'remove'])->name('favorites.remove');
});

Route::get('/produtos/{product}', [ProductController::class, 'show'])->name('products.show');

require __DIR__.'/auth.php';
