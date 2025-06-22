<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Registro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-amber-900 via-orange-800 to-yellow-700">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-4xl bg-white/10 backdrop-blur-md rounded-2xl border border-amber-500/30 overflow-hidden shadow-2xl">
            <div class="flex flex-col lg:flex-row">
                <!-- Banner Lateral -->
                <div class="lg:w-1/2 bg-gradient-to-br from-amber-600 via-orange-500 to-yellow-500 p-8 lg:p-12 flex items-center justify-center">
                    <div class="text-center text-white">
                        <div class="mb-6">
                            <div class="w-24 h-36 bg-white/20 rounded-full mx-auto mb-4"></div>
                        </div>
                        <h2 class="text-3xl font-black mb-4">JUNTE-SE A NÓS!</h2>
                        <div class="space-y-3 text-lg">
                            <p class="font-bold">🌟 Seja parte da nossa comunidade</p>
                            <p class="opacity-90">✨ Garrafas personalizadas para você</p>
                            <p class="opacity-90">💎 Qualidade premium garantida</p>
                        </div>
                    </div>
                </div>

                <!-- Formulário -->
                <div class="lg:w-1/2 p-8 lg:p-12 bg-white/5">
                    <!-- Logo -->
                    <div class="text-center mb-8">
                        <img src="{{ asset('newlogohorizontal.png') }}" alt="HydrateLife Logo" class="mx-auto h-16 w-auto mb-4">
                        <h1 class="text-2xl font-black text-white mb-2">CRIAR CONTA</h1>
                        <p class="text-gray-300">Preencha seus dados</p>
                    </div>

                    <!-- Form -->
                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-bold text-white mb-2">
                                👤 NOME COMPLETO
                            </label>
                            <input id="name" 
                                   type="text" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   required 
                                   autofocus 
                                   autocomplete="name"
                                   class="w-full px-4 py-3 bg-white/10 border border-amber-500/30 rounded-xl text-white placeholder-gray-300 focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20 transition-all duration-300"
                                   placeholder="Digite seu nome completo">
                            @error('name')
                                <p class="mt-2 text-red-300 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-bold text-white mb-2">
                                📧 E-MAIL
                            </label>
                            <input id="email" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   required 
                                   autocomplete="username"
                                   class="w-full px-4 py-3 bg-white/10 border border-amber-500/30 rounded-xl text-white placeholder-gray-300 focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20 transition-all duration-300"
                                   placeholder="Digite seu e-mail">
                            @error('email')
                                <p class="mt-2 text-red-300 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-bold text-white mb-2">
                                🔒 SENHA
                            </label>
                            <input id="password" 
                                   type="password" 
                                   name="password" 
                                   required 
                                   autocomplete="new-password"
                                   class="w-full px-4 py-3 bg-white/10 border border-amber-500/30 rounded-xl text-white placeholder-gray-300 focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20 transition-all duration-300"
                                   placeholder="Crie uma senha forte">
                            @error('password')
                                <p class="mt-2 text-red-300 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-white mb-2">
                                ✅ CONFIRMAR SENHA
                            </label>
                            <input id="password_confirmation" 
                                   type="password" 
                                   name="password_confirmation" 
                                   required 
                                   autocomplete="new-password"
                                   class="w-full px-4 py-3 bg-white/10 border border-amber-500/30 rounded-xl text-white placeholder-gray-300 focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20 transition-all duration-300"
                                   placeholder="Confirme sua senha">
                        </div>

                        <!-- Terms -->
                        <div class="flex items-start cursor-pointer">
                            <input id="terms" 
                                   type="checkbox" 
                                   name="terms"
                                   required
                                   class="w-4 h-4 text-amber-500 border-amber-500 rounded focus:ring-amber-500 focus:ring-2 bg-white/10 mt-1">
                            <label for="terms" class="ml-2 text-white text-sm font-medium">
                                Concordo com os <a href="#" class="text-amber-300 hover:text-amber-200 underline">Termos de Uso</a> e <a href="#" class="text-amber-300 hover:text-amber-200 underline">Política de Privacidade</a>
                            </label>
                        </div>

                        <!-- Register Button -->
                        <button type="submit" 
                                class="w-full py-3 px-6 bg-gradient-to-r from-amber-500 to-orange-500 text-black rounded-xl font-black text-lg hover:scale-105 hover:shadow-xl transition-all duration-300 transform">
                            🚀 CRIAR MINHA CONTA
                        </button>
                    </form>

                    <!-- Login Link -->
                    <div class="mt-8 text-center">
                        <p class="text-gray-300 text-sm">
                            Já tem uma conta? 
                            <a href="{{ route('login') }}" 
                               class="text-amber-300 hover:text-amber-200 font-bold transition-colors duration-300">
                                FAÇA LOGIN AQUI
                            </a>
                        </p>
                    </div>

                    <!-- Back to Home -->
                    <div class="text-center mt-6">
                        <a href="{{ url('/') }}" 
                           class="inline-flex items-center px-6 py-2 bg-white/10 rounded-full text-white text-sm font-bold hover:bg-white/20 transition-all duration-300 border border-white/20">
                            ← VOLTAR AO INÍCIO
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
