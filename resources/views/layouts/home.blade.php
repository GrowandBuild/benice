<!DOCTYPE html>
<html lang="pt-BR">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BE NICE - Garrafas Personalizadas com Marcação a Laser</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .hero-gradient { background: linear-gradient(135deg, #D4AF37 0%, #8B4513 50%, #4682B4 100%); }
        .egyptian-gold { background: linear-gradient(135deg, #CD853F 0%, #D4AF37 50%, #DEB887 100%); }
        .egyptian-gold-light { background: linear-gradient(135deg, #D4AF37 0%, #F4E4BC 50%, #CD853F 100%); }
        .egyptian-gold-dark { background: linear-gradient(135deg, #A0522D 0%, #CD853F 50%, #B8860B 100%); }
        .egyptian-gold-shine { background: linear-gradient(45deg, #8B4513 0%, #A0522D 15%, #CD853F 30%, #D4AF37 45%, #FFD700 60%, #FFF8DC 75%, #FFFFFF 90%, #8B4513 100%); background-size: 200% 200%; animation: shine 1.5s ease-in-out infinite; }
        @keyframes shine { 
            0% { background-position: 0% 50%; } 
            50% { background-position: 100% 50%; } 
            100% { background-position: 0% 50%; } 
        }
        .mediterranean-blue { background: linear-gradient(135deg, #4682B4 0%, #1E90FF 100%); }
        .terracotta { background: linear-gradient(135deg, #CD5C5C 0%, #DC143C 100%); }
        .sand-beige { background: linear-gradient(135deg, #F5DEB3 0%, #DEB887 100%); }
        .category-card { transition: all 0.3s ease; }
        .category-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(212, 175, 55, 0.3); }
        .product-card { transition: all 0.3s ease; }
        .product-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(212, 175, 55, 0.2); }
        .price { color: #D4AF37; font-weight: bold; }
        .old-price { text-decoration: line-through; color: #666; }
        .discount-badge { background: #CD5C5C; color: white; padding: 2px 6px; border-radius: 8px; font-size: 0.7rem; }
        .btn-primary { background: #D4AF37; color: white; padding: 12px 24px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: all 0.3s ease; }
        .btn-primary:hover { background: #B8860B; transform: translateY(-2px); }
        .btn-secondary { background: white; color: #D4AF37; padding: 12px 24px; border: 2px solid #D4AF37; border-radius: 8px; font-weight: bold; cursor: pointer; transition: all 0.3s ease; }
        .btn-secondary:hover { background: #D4AF37; color: white; }
        .star { color: #FFD700; }
        .star-empty { color: #ddd; }
        .egyptian-pattern { background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23D4AF37' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }
        .personalization-preview { border: 2px dashed #D4AF37; background: linear-gradient(45deg, #F5DEB3 25%, transparent 25%), linear-gradient(-45deg, #F5DEB3 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #F5DEB3 75%), linear-gradient(-45deg, transparent 75%, #F5DEB3 75%); background-size: 20px 20px; background-position: 0 0, 0 10px, 10px -10px, -10px 0px; }
    </style>
</head>
<body class="bg-gray-50" x-data="{ mobileMenuOpen: false }">
    @include('layouts.navigation')

    <main>
        @yield('content')
    </main>
    <!-- Footer -->
    <footer class="bg-[#8B4513] text-white">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <div>
                    <img src="{{ asset('newlogohorizontal.png') }}" alt="BE NICE Logo" class="max-h-16 h-auto object-contain mb-4 filter brightness-110 contrast-125 drop-shadow-lg">
                    <p class="text-sm text-white/80">Sua dose diária de inspiração e hidratação, com um toque de personalidade.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Links Rápidos</h4>
                    <ul>
                        <li><a href="#" class="hover:underline">Sobre Nós</a></li>
                        <li><a href="#" class="hover:underline">Contato</a></li>
                        <li><a href="#" class="hover:underline">FAQ</a></li>
                        <li><a href="#" class="hover:underline">Política de Privacidade</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Categorias</h4>
                    <ul>
                        <li><a href="#" class="hover:underline">Garrafas Personalizadas</a></li>
                        <li><a href="#" class="hover:underline">Fitness & Wellness</a></li>
                        <li><a href="#" class="hover:underline">Presentes</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Siga-nos</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="hover:text-[#D4AF37]"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="hover:text-[#D4AF37]"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="hover:text-[#D4AF37]"><i class="fab fa-tiktok fa-lg"></i></a>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center border-t border-[#D4AF37]/20 pt-8">
                <div class="text-center md:text-left text-sm text-white/80">
                <p>&copy; {{ date('Y') }} BE NICE. Todos os direitos reservados.</p>
                </div>
                <div class="flex justify-center md:justify-end items-center space-x-2">
                    <p class="text-sm text-white/80">Pagamento seguro com:</p>
                    <i class="fab fa-cc-visa fa-2x"></i>
                    <i class="fab fa-cc-mastercard fa-2x"></i>
                    <i class="fab fa-cc-paypal fa-2x"></i>
                </div>
            </div>
        </div>
    </footer>
    @stack('scripts')
</body>
</html> 