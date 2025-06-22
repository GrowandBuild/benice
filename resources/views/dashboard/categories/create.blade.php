@extends('layouts.home')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-cyan-50 to-teal-50">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 via-cyan-500 to-teal-500 shadow-lg">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">✨ Criar Nova Categoria</h1>
                    <p class="text-blue-100 text-lg">Organize seus produtos com categorias</p>
                </div>
                <a href="{{ route('dashboard.categories.index') }}" 
                   class="group relative inline-flex items-center px-6 py-3 bg-white bg-opacity-20 backdrop-blur-sm rounded-full text-white font-semibold transition-all duration-300 hover:bg-opacity-30 hover:scale-105 hover:shadow-xl">
                    <span class="mr-2">←</span>
                    Voltar
                </a>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-3xl mx-auto px-6 py-12">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-blue-100">
            <div class="bg-gradient-to-r from-blue-50 to-cyan-50 px-8 py-6 border-b border-blue-200">
                <h2 class="text-2xl font-bold text-blue-800">📝 Formulário da Categoria</h2>
            </div>
            
            <form action="{{ route('dashboard.categories.store') }}" method="POST" class="p-8">
                @csrf
                
                <!-- Nome da Categoria -->
                <div class="mb-8">
                    <label for="name" class="block text-lg font-semibold text-blue-800 mb-3">
                        <span class="mr-2">🏷️</span>Nome da Categoria
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="w-full px-6 py-4 border-2 border-blue-200 rounded-2xl text-lg focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 bg-gradient-to-r from-blue-50 to-cyan-50"
                           placeholder="Digite o nome da categoria">
                    @error('name')
                        <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug (Auto-gerado) -->
                <div class="mb-8">
                    <label for="slug" class="block text-lg font-semibold text-blue-800 mb-3">
                        <span class="mr-2">🔗</span>Slug (URL)
                    </label>
                    <input type="text" 
                           id="slug" 
                           name="slug" 
                           value="{{ old('slug') }}"
                           class="w-full px-6 py-4 border-2 border-blue-200 rounded-2xl text-lg focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 bg-gradient-to-r from-blue-50 to-cyan-50"
                           placeholder="sera-gerado-automaticamente">
                    <p class="mt-2 text-blue-600 text-sm">O slug será gerado automaticamente baseado no nome da categoria</p>
                    @error('slug')
                        <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between mt-12 pt-8 border-t border-blue-200">
                    <a href="{{ route('dashboard.categories.index') }}" 
                       class="group relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-gray-500 to-gray-600 text-white rounded-full font-semibold text-lg transition-all duration-300 hover:scale-105 hover:shadow-lg">
                        <span class="mr-2">←</span>
                        Cancelar
                    </a>
                    
                    <button type="submit" 
                            class="group relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-full font-semibold text-lg transition-all duration-300 hover:scale-105 hover:shadow-xl">
                        <span class="mr-2">✨</span>
                        Criar Categoria
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-cyan-400 rounded-full opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Custom focus styles */
    input:focus {
        outline: none;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.2);
    }
    
    /* Smooth transitions */
    * {
        transition: all 0.3s ease;
    }
</style>

<script>
    // Auto-generate slug from name
    document.getElementById('name').addEventListener('input', function() {
        const name = this.value;
        const slug = name
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        document.getElementById('slug').value = slug;
    });
</script>
@endsection 