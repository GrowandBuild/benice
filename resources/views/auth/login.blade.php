<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Login</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-amber-900 via-orange-800 to-yellow-700">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white/10 backdrop-blur-md rounded-2xl border border-amber-500/30 overflow-hidden shadow-2xl p-8">
            <!-- Logo -->
            <div class="text-center mb-8">
                <img src="{{ asset('newlogohorizontal.png') }}" alt="HydrateLife Logo" class="mx-auto h-16 w-auto mb-4">
                <h1 class="text-2xl font-black text-white mb-2">ACESSAR CONTA</h1>
                <p class="text-gray-300">Entre com suas credenciais</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-6 p-4 bg-green-500 rounded-xl text-white text-center">
                    <div class="flex items-center justify-center">
                        <span class="text-xl mr-2">✅</span>
                        <span class="font-bold">{{ session('status') }}</span>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

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
                           autofocus 
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
                           autocomplete="current-password"
                           class="w-full px-4 py-3 bg-white/10 border border-amber-500/30 rounded-xl text-white placeholder-gray-300 focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20 transition-all duration-300"
                           placeholder="Digite sua senha">
                    @error('password')
                        <p class="mt-2 text-red-300 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer">
                        <input id="remember_me" 
                               type="checkbox" 
                               name="remember"
                               class="w-4 h-4 text-amber-500 border-amber-500 rounded focus:ring-amber-500 focus:ring-2 bg-white/10">
                        <span class="ml-2 text-white text-sm font-medium">
                            Lembrar de mim
                        </span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" 
                           class="text-amber-300 hover:text-amber-200 text-sm font-bold transition-colors duration-300">
                            Esqueceu a senha?
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <button type="submit" 
                        class="w-full py-3 px-6 bg-gradient-to-r from-amber-500 to-orange-500 text-black rounded-xl font-black text-lg hover:scale-105 hover:shadow-xl transition-all duration-300 transform">
                    🚀 ENTRAR NA CONTA
                </button>
            </form>

            <!-- Register Link -->
            <div class="mt-8 text-center">
                <p class="text-gray-300 text-sm">
                    Não tem uma conta? 
                    <a href="{{ route('register') }}" 
                       class="text-amber-300 hover:text-amber-200 font-bold transition-colors duration-300">
                        CADASTRE-SE AQUI
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
</body>
</html>
