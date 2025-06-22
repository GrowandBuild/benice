<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Acesso</title>

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
        <style>
            .egyptian-pattern { background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23D4AF37' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }
            .btn-primary { background: #D4AF37; color: white; padding: 12px 24px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: all 0.3s ease; }
            .btn-primary:hover { background: #B8860B; }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 egyptian-pattern">
            <div class="mb-6">
                <a href="/">
                    <img src="{{ asset('newlogohorizontal.png') }}" alt="BE NICE Logo" class="h-16 w-auto object-contain">
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-2xl overflow-hidden sm:rounded-2xl border-t-4 border-[#D4AF37]">
                {{ $slot }}
            </div>
            <div class="mt-4 text-center">
                 <a href="{{ url('/') }}"
                    class="text-sm text-gray-600 font-semibold hover:text-[#D4AF37] transition-colors">
                     ← Voltar para a loja
                 </a>
             </div>
        </div>
    </body>
</html>
