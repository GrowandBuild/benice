<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-6 lg:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-6 text-sm sm:text-base" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ url('/') }}" class="text-gray-700 hover:text-[#D4AF37] inline-flex items-center">
                            <i class="fas fa-home mr-2"></i> Início
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-1 sm:mx-2"></i>
                            <a href="{{ route('orders.index') }}" class="text-gray-700 hover:text-[#D4AF37]">Meus Pedidos</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-1 sm:mx-2"></i>
                            <span class="text-[#D4AF37] font-medium">Pedido #{{ $order->id }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            @if (session('pix_qr_code') && $order->payment_method == 'pix' && $order->status == 'pending')
            <div class="text-center mb-8 lg:mb-12">
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-gray-900">
                    Seu pedido foi criado! Só falta o pagamento.
                </h1>
                <p class="mt-3 max-w-2xl mx-auto text-base md:text-lg text-gray-600">
                    Pedido <span class="font-bold text-[#D4AF37]">#{{ $order->id }}</span>
                </p>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                <!-- Coluna do Pagamento PIX -->
                @if (session('pix_qr_code') && $order->payment_method == 'pix' && $order->status == 'pending')
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden order-first lg:order-last">
                    <div class="p-6 lg:p-8">
                        <h2 class="text-xl lg:text-2xl font-bold text-gray-800 mb-6 text-center">Pague com Pix para finalizar</h2>
                        <div class="flex justify-center mb-4">
                            <img src="data:image/png;base64, {{ session('pix_qr_code') }}" alt="Pix QR Code" class="w-48 h-48 lg:w-56 lg:h-56 rounded-xl border-4 border-gray-200">
                        </div>
                        <p class="text-center text-gray-600 mb-6">Escaneie o QR code com seu app de pagamentos.</p>
                        
                        <div class="relative mb-4">
                            <input type="text" id="pix_code" value="{{ session('pix_qr_code_text') }}" readonly
                                   class="w-full bg-gray-50 border-2 border-gray-300 rounded-lg p-3 text-sm text-center pr-24 focus:ring-[#D4AF37] focus:border-[#D4AF37]">
                            <button onclick="copyToClipboard(this)" 
                                    class="absolute right-1.5 top-1/2 -translate-y-1/2 bg-[#D4AF37] hover:bg-[#B8941F] text-white px-3 py-1.5 rounded-lg font-semibold text-sm transition-all">
                                Copiar
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 text-center">Após o pagamento, o status do seu pedido será atualizado automaticamente.</p>
                    </div>
                </div>
                @endif

                <!-- Coluna dos Detalhes do Pedido -->
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden p-6 lg:p-8">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
                            <h3 class="text-lg lg:text-xl font-bold text-gray-800">Resumo da Compra</h3>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                @elseif($order->status === 'completed') bg-green-100 text-green-800
                                @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                @switch($order->status)
                                    @case('pending') Pendente @break
                                    @case('processing') Processando @break
                                    @case('completed') Concluído @break
                                    @case('cancelled') Cancelado @break
                                    @default {{ ucfirst($order->status) }}
                                @endswitch
                            </span>
                        </div>
                        
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ $item->product->image_url ?? 'https://via.placeholder.com/60x60' }}"
                                         alt="{{ $item->product->name ?? 'Produto' }}"
                                         class="w-16 h-16 rounded-xl object-cover border border-gray-200">
                                    <div>
                                        <div class="font-semibold text-gray-800">{{ $item->product->name ?? 'Produto não encontrado' }}</div>
                                        <div class="text-sm text-gray-500">Quantidade: {{ $item->quantity }}</div>
                                    </div>
                                </div>
                                <div class="font-semibold text-[#D4AF37]">R$ {{ number_format($item->price * $item->quantity, 2, ',', '.') }}</div>
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="border-t border-gray-200 my-6"></div>
                        
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold">R$ {{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity), 2, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Frete</span>
                                <span class="font-semibold">R$ {{ number_format($order->shipping_cost, 2, ',', '.') }}</span>
                            </div>
                            <div class="border-t border-gray-200 pt-2 flex justify-between">
                                <span class="text-lg font-bold text-gray-800">Total</span>
                                <span class="text-lg font-bold text-[#D4AF37]">R$ {{ number_format($order->total, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    @if($order->address)
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden p-6 lg:p-8">
                        <h3 class="text-lg lg:text-xl font-bold text-gray-800 mb-4">Detalhes da Entrega</h3>
                        <div class="text-gray-700 space-y-1">
                            <p><strong>{{ $order->address->name }}</strong></p>
                            <p>{{ $order->address->full_address }}</p>
                            <p>CEP: {{ $order->address->zip_code }}</p>
                            <p>Telefone: {{ $order->address->phone }}</p>
                        </div>
                    </div>
                    @endif
                     <div class="text-center mt-4">
                        <a href="{{ url('/') }}"
                           class="inline-flex items-center text-gray-600 font-semibold hover:text-[#D4AF37] transition-colors">
                            <span class="mr-2">←</span>
                            Continuar comprando
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(button) {
            const text = document.getElementById('pix_code').value;
            navigator.clipboard.writeText(text).then(function() {
                button.textContent = 'Copiado!';
                setTimeout(() => {
                    button.textContent = 'Copiar';
                }, 2000);
            }, function(err) {
                alert('Não foi possível copiar o código.');
            });
        }
    </script>
</x-app-layout>
<style>
    .price { color: #D4AF37; font-weight: bold; }
    .btn-primary { background: #D4AF37; color: white; transition: all 0.3s ease; }
</style> 