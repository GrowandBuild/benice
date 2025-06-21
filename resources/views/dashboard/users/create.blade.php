<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-600 via-indigo-500 to-purple-500 shadow-lg">
            <div class="max-w-4xl mx-auto px-6 py-8">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mr-6">
                        <i class="fas fa-user-plus text-3xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold text-white mb-1">Adicionar Novo Usuário</h1>
                        <p class="text-blue-100 text-lg">Crie um novo perfil e defina suas permissões</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="max-w-4xl mx-auto px-6 py-12">
            <div class="bg-white rounded-3xl shadow-2xl p-8 border border-blue-100">
                <form action="{{ route('dashboard.users.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-lg font-semibold text-gray-700 mb-2">Nome</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-indigo-200 transition-all duration-300"
                                   required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-lg font-semibold text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-indigo-200 transition-all duration-300"
                                   required>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-lg font-semibold text-gray-700 mb-2">Senha</label>
                            <input type="password" name="password" id="password"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-indigo-200 transition-all duration-300"
                                   required>
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div>
                            <label for="role" class="block text-lg font-semibold text-gray-700 mb-2">Função (Role)</label>
                            <select name="role" id="role" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-indigo-200 transition-all duration-300">
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-10 pt-6 border-t border-gray-200 flex items-center justify-end space-x-4">
                        <a href="{{ route('dashboard.users.index') }}" class="px-6 py-3 text-gray-600 font-semibold rounded-xl hover:bg-gray-100 transition-all duration-300">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="group relative inline-flex items-center px-8 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-semibold transition-all duration-300 hover:scale-105 hover:shadow-lg">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Criar Usuário
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 