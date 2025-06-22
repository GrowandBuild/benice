<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .egyptian-gold { background: linear-gradient(135deg, #CD853F 0%, #D4AF37 50%, #DEB887 100%); }
            .egyptian-gold-shine { background: linear-gradient(45deg, #8B4513 0%, #A0522D 15%, #CD853F 30%, #D4AF37 45%, #FFD700 60%, #FFF8DC 75%, #FFFFFF 90%, #8B4513 100%); background-size: 200% 200%; animation: shine 1.5s ease-in-out infinite; }
            @keyframes shine { 
                0% { background-position: 0% 50%; } 
                50% { background-position: 100% 50%; } 
                100% { background-position: 0% 50%; } 
            }
            .egyptian-pattern { background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23D4AF37' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @if(request()->is('/'))
                @include('layouts.navigation')
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            @if(request()->is('/'))
                @include('layouts.footer')
            @endif
        </div>
        @stack('scripts')
    </body>
</html>
