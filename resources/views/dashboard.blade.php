@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-amber-600 via-orange-500 to-yellow-500 shadow-lg">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="text-center">
                <h1 class="text-5xl font-bold text-white mb-4">✨ Painel Administrativo</h1>
                <p class="text-amber-100 text-xl">Bem-vindo ao seu centro de controle</p>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-7xl mx-auto px-6 py-12">
        <!-- Welcome Message -->
        <div class="mb-12 text-center">
            <div class="bg-gradient-to-r from-green-400 to-emerald-500 rounded-3xl p-8 shadow-2xl text-white">
                <div class="text-6xl mb-4">🎉</div>
                <h2 class="text-3xl font-bold mb-2">Bem-vindo, {{ Auth::user()->name }}!</h2>
                <p class="text-xl opacity-90">Gerencie seus produtos e categorias com elegância</p>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
            <div class="bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl p-6 text-white shadow-lg transform hover:scale-105 transition-transform duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-amber-100 text-sm font-medium">Total de Produtos</p>
                        <p class="text-3xl font-bold">{{ \App\Models\Product::count() }}</p>
                    </div>
                    <div class="text-4xl">📦</div>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-blue-400 to-cyan-500 rounded-2xl p-6 text-white shadow-lg transform hover:scale-105 transition-transform duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Categorias</p>
                        <p class="text-3xl font-bold">{{ \App\Models\Category::count() }}</p>
                    </div>
                    <div class="text-4xl">🏷️</div>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-green-400 to-emerald-500 rounded-2xl p-6 text-white shadow-lg transform hover:scale-105 transition-transform duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Em Estoque</p>
                        <p class="text-3xl font-bold">{{ \App\Models\Product::where('stock', '>', 0)->count() }}</p>
                    </div>
                    <div class="text-4xl">✅</div>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-purple-400 to-pink-500 rounded-2xl p-6 text-white shadow-lg transform hover:scale-105 transition-transform duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Usuários</p>
                        <p class="text-3xl font-bold">{{ \App\Models\User::count() }}</p>
                    </div>
                    <div class="text-4xl">👥</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <!-- Products Management -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-amber-100">
                <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-8 py-6 border-b border-amber-200">
                    <h3 class="text-2xl font-bold text-amber-800">📦 Gestão de Produtos</h3>
                </div>
                <div class="p-8">
                    <p class="text-gray-600 mb-6">Gerencie seu catálogo de produtos com facilidade</p>
                    <div class="space-y-4">
                        <a href="{{ route('dashboard.products.index') }}" 
                           class="group relative inline-flex items-center w-full px-6 py-4 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-xl font-semibold transition-all duration-300 hover:scale-105 hover:shadow-lg">
                            <span class="mr-3 text-xl">📋</span>
                            Ver Todos os Produtos
                            <span class="ml-auto">→</span>
                        </a>
                        <a href="{{ route('dashboard.products.create') }}" 
                           class="group relative inline-flex items-center w-full px-6 py-4 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-xl font-semibold transition-all duration-300 hover:scale-105 hover:shadow-lg">
                            <span class="mr-3 text-xl">✨</span>
                            Adicionar Novo Produto
                            <span class="ml-auto">→</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Categories Management -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-blue-100">
                <div class="bg-gradient-to-r from-blue-50 to-cyan-50 px-8 py-6 border-b border-blue-200">
                    <h3 class="text-2xl font-bold text-blue-800">🏷️ Gestão de Categorias</h3>
                </div>
                <div class="p-8">
                    <p class="text-gray-600 mb-6">Organize seus produtos em categorias</p>
                    <div class="space-y-4">
                        <a href="{{ route('dashboard.categories.index') }}" 
                           class="group relative inline-flex items-center w-full px-6 py-4 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-xl font-semibold transition-all duration-300 hover:scale-105 hover:shadow-lg">
                            <span class="mr-3 text-xl">📂</span>
                            Ver Todas as Categorias
                            <span class="ml-auto">→</span>
                        </a>
                        <a href="{{ route('dashboard.categories.create') }}" 
                           class="group relative inline-flex items-center w-full px-6 py-4 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-xl font-semibold transition-all duration-300 hover:scale-105 hover:shadow-lg">
                            <span class="mr-3 text-xl">✨</span>
                            Criar Nova Categoria
                            <span class="ml-auto">→</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Users Management -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-purple-100">
                <div class="bg-gradient-to-r from-purple-50 to-pink-500 px-8 py-6 border-b border-purple-200">
                    <h3 class="text-2xl font-bold text-purple-800">👥 Gestão de Usuários</h3>
                </div>
                <div class="p-8">
                    <p class="text-gray-600 mb-6">Administre usuários e permissões</p>
                    <div class="space-y-4">
                        <a href="{{ route('dashboard.users.index') }}" 
                           class="group relative inline-flex items-center w-full px-6 py-4 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-xl font-semibold transition-all duration-300 hover:scale-105 hover:shadow-lg">
                            <span class="mr-3 text-xl">📋</span>
                            Ver Todos os Usuários
                            <span class="ml-auto">→</span>
                        </a>
                        <a href="{{ route('dashboard.users.create') }}" 
                           class="group relative inline-flex items-center w-full px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-semibold transition-all duration-300 hover:scale-105 hover:shadow-lg">
                            <span class="mr-3 text-xl">✨</span>
                            Adicionar Novo Usuário
                            <span class="ml-auto">→</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Products -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-amber-100">
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-8 py-6 border-b border-amber-200">
                <h3 class="text-2xl font-bold text-amber-800">🆕 Produtos Recentes</h3>
            </div>
            <div class="p-8">
                @php
                    $recentProducts = \App\Models\Product::with('category')->latest()->take(5)->get();
                @endphp
                
                @if($recentProducts->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($recentProducts as $product)
                        <div class="group relative bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-6 border border-amber-200 hover:border-amber-300 transition-all duration-300 hover:shadow-xl hover:scale-105">
                            <div class="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center text-white font-bold text-lg mb-4">
                                {{ strtoupper(substr($product->name, 0, 2)) }}
                            </div>
                            
                            <h4 class="text-lg font-bold text-amber-800 mb-2">{{ $product->name }}</h4>
                            <p class="text-amber-600 text-sm mb-3">{{ Str::limit($product->description, 60) }}</p>
                            
                            <div class="flex items-center justify-between mb-4">
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                    R$ {{ number_format($product->price, 2, ',', '.') }}
                                </span>
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                    {{ $product->stock }} un
                                </span>
                            </div>
                            
                            <a href="{{ route('dashboard.products.edit', $product) }}" 
                               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-lg font-medium transition-all duration-300 hover:scale-105 hover:shadow-lg">
                                <span class="mr-2">✏️</span>
                                Editar
                            </a>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">📦</div>
                        <h4 class="text-2xl font-bold text-amber-800 mb-2">Nenhum produto encontrado</h4>
                        <p class="text-amber-600 mb-6">Comece criando seu primeiro produto</p>
                        <a href="{{ route('dashboard.products.create') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-full font-semibold transition-all duration-300 hover:scale-105 hover:shadow-lg">
                            <span class="mr-2">✨</span>
                            Criar Primeiro Produto
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
