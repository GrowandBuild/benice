<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .egyptian-pattern { background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23D4AF37' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }
        .btn-primary { background: #D4AF37; color: white; padding: 12px 24px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: all 0.3s ease; }
        .btn-primary:hover { background: #B8860B; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-amber-900 via-orange-800 to-yellow-700">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Logo -->
            <div class="text-center mb-8">
                <img src="{{ asset('newlogohorizontal.png') }}" alt="BE NICE Logo" class="mx-auto h-16 w-auto mb-4 filter brightness-110 contrast-125 drop-shadow-lg">
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
