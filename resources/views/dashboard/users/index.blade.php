<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-600 via-indigo-500 to-purple-500 shadow-lg">
            <div class="max-w-7xl mx-auto px-6 py-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-4xl font-bold text-white mb-2">👥 Gestão de Usuários</h1>
                        <p class="text-blue-100 text-lg">Gerencie os usuários e suas permissões</p>
                    </div>
                    <a href="{{ route('dashboard.users.create') }}" 
                       class="group relative inline-flex items-center px-8 py-4 bg-white bg-opacity-20 backdrop-blur-sm rounded-full text-white font-semibold text-lg transition-all duration-300 hover:bg-opacity-30 hover:scale-105 hover:shadow-xl">
                        <span class="mr-2 text-2xl">➕</span>
                        Novo Usuário
                    </a>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="max-w-7xl mx-auto px-6 py-12">
            @if(session('success'))
                <div class="mb-8 p-6 bg-gradient-to-r from-green-400 to-emerald-500 rounded-2xl shadow-lg text-white text-center">
                    <div class="flex items-center justify-center">
                        <span class="text-3xl mr-3">🎉</span>
                        <span class="text-xl font-semibold">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Users Table -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-blue-100">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-8 py-6 border-b border-blue-200">
                    <h2 class="text-2xl font-bold text-blue-800">📋 Lista de Usuários</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-blue-100 to-indigo-100">
                            <tr>
                                <th class="px-8 py-4 text-left text-blue-800 font-semibold text-lg">Usuário</th>
                                <th class="px-8 py-4 text-left text-blue-800 font-semibold text-lg">Email</th>
                                <th class="px-8 py-4 text-left text-blue-800 font-semibold text-lg">Função (Role)</th>
                                <th class="px-8 py-4 text-left text-blue-800 font-semibold text-lg">Data de Criação</th>
                                <th class="px-8 py-4 text-left text-blue-800 font-semibold text-lg">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-blue-100">
                            @foreach($users as $user)
                            <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-300 group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center text-white font-bold text-lg mr-4">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800 text-lg">{{ $user->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-gray-600">{{ $user->email }}</td>
                                <td class="px-8 py-6">
                                    @foreach($user->roles as $role)
                                        <span class="px-4 py-2 rounded-full text-sm font-medium
                                            @if($role->name == 'admin') bg-green-100 text-green-800 @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="px-8 py-6 text-gray-500">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('dashboard.users.edit', $user) }}" 
                                           class="group relative inline-flex items-center px-4 py-2 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-lg font-medium transition-all duration-300 hover:scale-105 hover:shadow-lg">
                                            <span class="mr-2">✏️</span>
                                            Editar
                                        </a>
                                        <form action="{{ route('dashboard.users.destroy', $user) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="group relative inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-lg font-medium transition-all duration-300 hover:scale-105 hover:shadow-lg"
                                                    onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                                                <span class="mr-2">🗑️</span>
                                                Excluir
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($users->hasPages())
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-8 py-6 border-t border-blue-200">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout> 