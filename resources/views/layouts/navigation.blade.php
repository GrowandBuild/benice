<div x-data="{ mobileMenuOpen: false }">
    <!-- Header -->
    <header @keydown.escape.window="mobileMenuOpen = false"
            class="bg-white/95 shadow-md border-b border-[#D4AF37]/50 sticky top-0 z-30 backdrop-blur-sm">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Main Header -->
            <div class="py-3">
                <div class="flex items-center justify-between gap-4">
                    <!-- Mobile Menu Button & Logo -->
                    <div class="flex items-center gap-3">
                        <button @click="mobileMenuOpen = true" class="lg:hidden text-[#8B4513] hover:text-[#D4AF37]">
                            <i class="fas fa-bars text-2xl"></i>
                        </button>
                        <a href="{{ url('/') }}" class="flex-shrink-0">
                            <img src="{{ asset('newlogohorizontal.png') }}" alt="BE NICE Logo" class="h-10 sm:h-12 w-auto object-contain">
                        </a>
                    </div>
                    
                    <!-- Desktop Search Bar -->
                    <div class="hidden lg:flex flex-1 justify-center px-8">
                        <div class="relative w-full max-w-xl">
                            <input type="text" placeholder="Busque sua garrafa personalizada..." 
                                   class="w-full pl-5 pr-14 py-3 border-2 border-[#D4AF37]/50 rounded-full focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition-all duration-300">
                            <button class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-[#D4AF37] text-white w-10 h-10 flex items-center justify-center rounded-full hover:bg-[#B8860B] transition-all duration-300">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Icons & User Menu -->
                    <nav class="flex items-center gap-4 sm:gap-6">
                        <!-- Search Icon (Mobile) -->
                        <button class="lg:hidden text-gray-600 hover:text-[#D4AF37]">
                             <i class="fas fa-search text-xl"></i>
                        </button>
    
                        <!-- Cart Icon -->
                        <a href="{{ route('cart.index') }}" class="relative flex items-center text-gray-600 hover:text-[#D4AF37] transition-colors duration-300">
                            <i class="fas fa-shopping-cart text-2xl"></i>
                            @auth
                                @php
                                    $cartCount = \App\Models\Cart::where('user_id', Auth::id())->first()?->items()->sum('quantity') ?? 0;
                                @endphp
                                @if($cartCount > 0)
                                    <span class="absolute -top-2 -right-2 bg-[#D4AF37] text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">{{ $cartCount }}</span>
                                @endif
                            @endauth
                        </a>
    
                        <!-- Desktop User Dropdown -->
                        <div class="hidden lg:relative lg:inline-block" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-600 hover:text-[#D4AF37] transition-colors duration-300 focus:outline-none">
                                <i class="fas fa-user-circle text-2xl"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform scale-95"
                                 x-transition:enter-end="opacity-100 transform scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 transform scale-100"
                                 x-transition:leave-end="opacity-0 transform scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200"
                                 style="display: none;">
                                @auth
                                    <div class="px-4 py-2 text-sm text-gray-700 border-b">Olá, <span class="font-semibold">{{ Auth::user()->name }}</span></div>
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Minha Conta</a>
                                    @hasrole('admin')
                                        <a href="{{ route('dashboard.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                    @endhasrole
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); this.closest('form').submit();"
                                           class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Sair
                                        </a>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Entrar</a>
                                    <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Cadastrar</a>
                                @endauth
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Secondary Navigation -->
        <nav class="hidden lg:flex bg-white border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-center h-12 space-x-8">
                    <x-nav-link :href="url('/')" :active="request()->is('/')">
                        Página Inicial
                    </x-nav-link>
                    <x-nav-link :href="route('favorites.index')" :active="request()->routeIs('favorites.index')">
                        Favoritos
                    </x-nav-link>
                    <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                        Meus Pedidos
                    </x-nav-link>
                    @hasrole('admin')
                        <x-nav-link :href="route('dashboard.products.index')" :active="request()->routeIs('dashboard.products.*')">
                            {{ __('Produtos') }}
                        </x-nav-link>
                        <x-nav-link :href="route('dashboard.categories.index')" :active="request()->routeIs('dashboard.categories.*')">
                            {{ __('Categorias') }}
                        </x-nav-link>
                        <x-nav-link :href="route('dashboard.attributes.index')" :active="request()->routeIs('dashboard.attributes.*')">
                            {{ __('Atributos') }}
                        </x-nav-link>
                        <x-nav-link :href="route('dashboard.users.index')" :active="request()->routeIs('dashboard.users.*')">
                            {{ __('Utilizadores') }}
                        </x-nav-link>
                    @endhasrole
                </div>
            </div>
        </nav>
    </header>
    
    <!-- Mobile Menu Container -->
    <div x-show="mobileMenuOpen" style="display: none;" class="lg:hidden" x-cloak>
        <!-- ... (código do overlay) ... -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="ease-in-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in-out duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileMenuOpen = false" 
             class="fixed inset-0 bg-black/40 z-40"></div>
    
        <!-- Menu Panel -->
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="fixed inset-y-0 left-0 w-full max-w-sm bg-white z-50 flex flex-col">
            
            <!-- Menu Header -->
            <div class="px-5 py-4 bg-[#8B4513] text-white flex items-center justify-between shadow-lg">
                <div class="flex items-center gap-3">
                    <i class="fas fa-user-circle text-2xl"></i>
                    @auth
                        <span class="font-semibold text-lg">Olá, {{ Auth::user()->name }}</span>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-lg">Entrar ou Cadastrar</a>
                    @endauth
                </div>
                <button @click="mobileMenuOpen = false" class="text-white hover:text-amber-300">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            
            <!-- Navigation Links -->
            <nav class="flex-grow p-5 overflow-y-auto">
                <div class="space-y-4">
                     @auth
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 p-3 rounded-lg hover:bg-gray-100 transition-colors">
                            <i class="fas fa-user w-6 text-center text-gray-500"></i>
                            <span class="font-semibold text-gray-700">Minha Conta</span>
                        </a>
                        <a href="{{ route('orders.index') }}" class="flex items-center gap-4 p-3 rounded-lg hover:bg-gray-100 transition-colors">
                            <i class="fas fa-box w-6 text-center text-gray-500"></i>
                            <span class="font-semibold text-gray-700">Meus Pedidos</span>
                        </a>
                        <a href="{{ route('favorites.index') }}" class="flex items-center gap-4 p-3 rounded-lg hover:bg-gray-100 transition-colors">
                            <i class="fas fa-heart w-6 text-center text-gray-500"></i>
                            <span class="font-semibold text-gray-700">Favoritos</span>
                        </a>
                        @hasrole('admin')
                            <a href="{{ route('dashboard.index') }}" class="flex items-center gap-4 p-3 rounded-lg hover:bg-gray-100 transition-colors">
                                <i class="fas fa-tachometer-alt w-6 text-center text-gray-500"></i>
                                <span class="font-semibold text-gray-700">Dashboard</span>
                            </a>
                        @endhasrole
                    @endauth
    
                    <div class="pt-4 border-t">
                        <h3 class="px-3 text-sm font-semibold text-gray-400 uppercase tracking-wider">Categorias</h3>
                         <div class="mt-2 space-y-1">
                            <a href="#" class="flex items-center gap-4 p-3 rounded-lg hover:bg-gray-100 transition-colors">
                                <span class="font-semibold text-gray-700">Garrafas Personalizadas</span>
                            </a>
                            <a href="#" class="flex items-center gap-4 p-3 rounded-lg hover:bg-gray-100 transition-colors">
                                <span class="font-semibold text-gray-700">Fitness & Wellness</span>
                            </a>
                            <a href="#" class="flex items-center gap-4 p-3 rounded-lg hover:bg-gray-100 transition-colors">
                                <span class="font-semibold text-gray-700">Presentes</span>
                            </a>
                            <a href="#" class="flex items-center gap-4 p-3 rounded-lg hover:bg-gray-100 transition-colors">
                                <span class="font-semibold text-gray-700">Atendimento</span>
                            </a>
                         </div>
                    </div>
                </div>
            </nav>
    
            @auth
            <!-- Footer Logout -->
            <div class="p-5 border-t">
                 <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-4 p-3 rounded-lg hover:bg-red-50 text-red-600 transition-colors">
                         <i class="fas fa-sign-out-alt w-6 text-center"></i>
                         <span class="font-semibold">Sair</span>
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </div>
</div>
