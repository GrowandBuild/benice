@extends('layouts.home')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-100 to-gray-200 egyptian-pattern">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-gray-800 via-gray-700 to-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">⚙️ Gerenciar Atributos</h1>
                    <p class="text-gray-300 text-lg">Gerencie os atributos e seus valores para as variações de produtos.</p>
                </div>
                <a href="{{ route('dashboard.attributes.create') }}" 
                   class="group relative inline-flex items-center px-6 py-3 bg-white bg-opacity-20 backdrop-blur-sm rounded-full text-white font-semibold transition-all duration-300 hover:bg-opacity-30 hover:scale-105 hover:shadow-xl">
                    <span class="mr-2">✨</span>
                    Adicionar Novo Atributo
                </a>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-200">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">Lista de Atributos</h2>
            </div>
            
            <div class="p-8">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" role="alert">
                        <p class="font-bold">Sucesso!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                
                @if($attributes->isEmpty())
                    <div class="text-center py-12 px-6 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-300">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum atributo encontrado</h3>
                        <p class="mt-1 text-sm text-gray-500">Comece adicionando um novo atributo para seus produtos.</p>
                        <div class="mt-6">
                            <a href="{{ route('dashboard.attributes.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Novo Atributo
                            </a>
                        </div>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach ($attributes as $attribute)
                            <div class="bg-gray-50 rounded-2xl border border-gray-200 p-6 shadow-sm">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-xl font-bold text-gray-800">{{ $attribute->name }}</h3>
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('dashboard.attributes.edit', $attribute->id) }}" class="text-amber-600 hover:text-amber-800 font-semibold transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        <form action="{{ route('dashboard.attributes.destroy', $attribute->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover este atributo e todos os seus valores? Esta ação não pode ser desfeita.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="mt-4 flex flex-wrap gap-2">
                                    @forelse ($attribute->values as $value)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-800">
                                            {{ $value->value }}
                                        </span>
                                    @empty
                                        <span class="text-sm text-gray-500">Nenhum valor adicionado.</span>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 