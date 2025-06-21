@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-[#8B4513]">Gestão de Categorias</h1>
            <a href="{{ route('dashboard.categories.create') }}" class="bg-[#D4AF37] hover:bg-[#B8860B] text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                + Nova Categoria
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                @if($categories->isEmpty())
                    <div class="text-center py-10">
                        <h2 class="text-xl font-semibold text-gray-700">Nenhuma categoria encontrada.</h2>
                        <p class="text-gray-500 mt-2">Que tal criar a primeira?</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($categories as $category)
                        <div class="bg-gray-50 rounded-lg shadow-md border border-gray-200 p-6 flex flex-col justify-between hover:shadow-lg hover:border-[#D4AF37] transition-all duration-300">
                            <div>
                                <div class="flex justify-between items-start">
                                    <h3 class="text-xl font-bold text-[#8B4513] mb-2">{{ $category->name }}</h3>
                                    <span class="text-sm font-semibold text-gray-500 bg-gray-200 px-2 py-1 rounded-md">ID: {{ $category->id }}</span>
                                </div>
                                <p class="text-sm text-gray-600 mb-4">Slug: <span class="font-mono bg-gray-100 p-1 rounded">{{ $category->slug }}</span></p>
                                <p class="text-gray-700">
                                    <span class="font-bold text-lg text-[#B8860B]">{{ $category->products_count ?? 0 }}</span> 
                                    Produto(s) nesta categoria.
                                </p>
                            </div>
                            <div class="mt-6 flex items-center justify-end space-x-3 border-t pt-4">
                                <a href="{{ route('dashboard.categories.edit', $category->id) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors duration-300">
                                    <i class="fas fa-edit mr-1"></i>Editar
                                </a>
                                <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta categoria?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800 transition-colors duration-300">
                                        <i class="fas fa-trash-alt mr-1"></i>Excluir
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        @if($categories->hasPages())
            <div class="mt-6">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection 