@extends('layouts.home')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-100 to-gray-200 egyptian-pattern">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-gray-800 via-gray-700 to-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">✨ Adicionar Novo Atributo</h1>
                    <p class="text-gray-300 text-lg">Crie um novo atributo para as variações de produtos.</p>
                </div>
                <a href="{{ route('dashboard.attributes.index') }}" 
                   class="group relative inline-flex items-center px-6 py-3 bg-white bg-opacity-20 backdrop-blur-sm rounded-full text-white font-semibold transition-all duration-300 hover:bg-opacity-30 hover:scale-105 hover:shadow-xl">
                    <span class="mr-2">←</span>
                    Voltar para a Lista
                </a>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-4xl mx-auto px-6 py-12">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-200">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">Formulário de Atributo</h2>
            </div>
            
            <form action="{{ route('dashboard.attributes.store') }}" method="POST" class="p-8">
                @csrf
                
                <div class="space-y-6">
                    <!-- Nome do Atributo -->
                    <div>
                        <label for="name" class="block text-lg font-semibold text-gray-800 mb-3">
                            <span class="mr-2">🏷️</span>Nome do Atributo
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               class="w-full px-6 py-4 border-2 border-gray-200 rounded-2xl text-lg focus:border-amber-500 focus:ring-4 focus:ring-amber-100 transition-all duration-300 bg-gradient-to-r from-gray-50 to-gray-100"
                               placeholder="Ex: Cor, Tamanho, Voltagem"
                               required>
                        @error('name')
                            <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end mt-12 pt-8 border-t border-gray-200">
                    <a href="{{ route('dashboard.attributes.index') }}" 
                       class="px-8 py-3 bg-gray-200 text-gray-800 rounded-full font-semibold text-lg transition-all duration-300 hover:bg-gray-300 mr-4">
                        Cancelar
                    </a>
                    
                    <button type="submit" 
                            class="group relative inline-flex items-center px-8 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-full font-semibold text-lg transition-all duration-300 hover:scale-105 hover:shadow-xl">
                        <span class="mr-2">💾</span>
                        Salvar Atributo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 