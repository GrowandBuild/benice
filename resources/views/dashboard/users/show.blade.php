<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-600 via-indigo-500 to-purple-500 shadow-lg">
            <div class="max-w-4xl mx-auto px-6 py-8">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mr-6">
                        <i class="fas fa-user text-3xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold text-white mb-1">Detalhes do Usuário</h1>
                        <p class="text-blue-100 text-lg">Visualize as informações do perfil</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="max-w-4xl mx-auto px-6 py-12">
            <div class="bg-white rounded-3xl shadow-2xl p-8 border border-blue-100">
                <!-- User Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Name -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-2xl">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-user-circle text-2xl text-blue-600 mr-3"></i>
                            <h3 class="text-xl font-semibold text-gray-800">Nome</h3>
                        </div>
                        <p class="text-lg text-gray-700">{{ $user->name }}</p>
                    </div>

                    <!-- Email -->
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 rounded-2xl">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-envelope text-2xl text-green-600 mr-3"></i>
                            <h3 class="text-xl font-semibold text-gray-800">Email</h3>
                        </div>
                        <p class="text-lg text-gray-700">{{ $user->email }}</p>
                    </div>

                    <!-- Role -->
                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-6 rounded-2xl">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-shield-alt text-2xl text-purple-600 mr-3"></i>
                            <h3 class="text-xl font-semibold text-gray-800">Função</h3>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            {{ $user->hasRole('admin') ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ ucfirst($user->roles->first()->name ?? 'Nenhuma função') }}
                        </span>
                    </div>

                    <!-- Created At -->
                    <div class="bg-gradient-to-r from-orange-50 to-yellow-50 p-6 rounded-2xl">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-calendar-alt text-2xl text-orange-600 mr-3"></i>
                            <h3 class="text-xl font-semibold text-gray-800">Data de Criação</h3>
                        </div>
                        <p class="text-lg text-gray-700">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="bg-gray-50 p-6 rounded-2xl mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        Informações Adicionais
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <span class="text-sm font-medium text-gray-500">ID do Usuário:</span>
                            <p class="text-gray-800">#{{ $user->id }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Última Atualização:</span>
                            <p class="text-gray-800">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Status:</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Ativo
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('dashboard.users.index') }}" 
                       class="inline-flex items-center px-6 py-3 text-gray-600 font-semibold rounded-xl hover:bg-gray-100 transition-all duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Voltar à Lista
                    </a>
                    
                    <div class="flex space-x-4">
                        <a href="{{ route('dashboard.users.edit', $user) }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl font-semibold transition-all duration-300 hover:scale-105 hover:shadow-lg">
                            <i class="fas fa-edit mr-2"></i>
                            Editar Usuário
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 