@extends('layouts.home')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-100 to-gray-200 egyptian-pattern" x-data="{ values: {{ $attribute->values->toJson() }} }">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-gray-800 via-gray-700 to-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">✏️ Editar Atributo</h1>
                    <p class="text-gray-300 text-lg">Atualize o nome e os valores do atributo <span class="font-bold text-amber-400">{{ $attribute->name }}</span>.</p>
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
        <!-- Edit Attribute Name -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-200 mb-8">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">Nome do Atributo</h2>
            </div>
            <form action="{{ route('dashboard.attributes.update', $attribute->id) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')
                <label for="name" class="block text-lg font-semibold text-gray-800 mb-3">
                    <span class="mr-2">🏷️</span>Nome
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $attribute->name) }}"
                       class="w-full px-6 py-4 border-2 border-gray-200 rounded-2xl text-lg focus:border-amber-500 focus:ring-4 focus:ring-amber-100"
                       required>
                @error('name')
                    <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                @enderror
                <div class="flex justify-end mt-6">
                    <button type="submit" class="group relative inline-flex items-center px-8 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-full font-semibold text-lg">
                        <span class="mr-2">💾</span>
                        Salvar Nome
                    </button>
                </div>
            </form>
        </div>

        <!-- Manage Attribute Values -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-200">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">Valores do Atributo</h2>
            </div>
            <div class="p-8">
                <!-- Add New Value Form -->
                <form action="{{ route('dashboard.attributes.values.store', $attribute->id) }}" method="POST" class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-200">
                    @csrf
                    <div class="flex-grow">
                        <label for="new_value" class="sr-only">Novo Valor</label>
                        <input type="text"
                               id="new_value"
                               name="value"
                               class="w-full px-6 py-4 border-2 border-gray-200 rounded-2xl text-lg focus:border-amber-500 focus:ring-4 focus:ring-amber-100"
                               placeholder="Adicionar novo valor (ex: Azul, P, 110v)"
                               required>
                    </div>
                    <button type="submit" class="h-16 px-6 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-2xl font-semibold text-lg">
                        Adicionar
                    </button>
                </form>

                <!-- Existing Values List -->
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Valores Atuais</h3>
                <div class="space-y-3">
                    <template x-if="values.length === 0">
                        <p class="text-gray-500">Nenhum valor adicionado para este atributo.</p>
                    </template>
                    <template x-for="value in values" :key="value.id">
                        <div class="flex justify-between items-center bg-gray-50 rounded-xl p-3 pr-4 border border-gray-200">
                            <span class="font-medium text-gray-800" x-text="value.value"></span>
                            <form :action="'/dashboard/attributes/{{ $attribute->id }}/values/' + value.id" method="POST" onsubmit="return confirm('Tem certeza?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </form>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//unpkg.com/alpinejs" defer></script>
@endsection 