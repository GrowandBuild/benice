@extends('layouts.home')

@section('content')
    <div class="min-h-screen bg-gray-50 py-6 lg:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Progress Indicator -->
            <div class="mb-8">
                <div class="flex items-center justify-center space-x-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-[#D4AF37] text-white rounded-full flex items-center justify-center text-sm font-bold">1</div>
                        <span class="ml-2 text-sm font-medium text-gray-600">Carrinho</span>
                    </div>
                    <div class="w-8 h-1 bg-gray-300"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-[#D4AF37] text-white rounded-full flex items-center justify-center text-sm font-bold">2</div>
                        <span class="ml-2 text-sm font-medium text-gray-900">Checkout</span>
                    </div>
                    <div class="w-8 h-1 bg-gray-300"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-300 text-gray-500 rounded-full flex items-center justify-center text-sm font-bold">3</div>
                        <span class="ml-2 text-sm font-medium text-gray-400">Confirmação</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-[#D4AF37] to-[#B8941F] px-6 lg:px-8 py-6 lg:py-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <h1 class="text-2xl lg:text-3xl font-bold text-white flex items-center">
                            <span class="mr-3 text-3xl lg:text-4xl">💳</span> Finalizar Compra
                        </h1>
                        <a href="{{ route('cart.index') }}" class="inline-flex items-center px-4 lg:px-6 py-2 lg:py-3 bg-white bg-opacity-20 rounded-full text-white font-semibold hover:bg-opacity-30 transition-all duration-300 text-sm lg:text-base">
                            <span class="mr-2">←</span> Voltar ao Carrinho
                        </a>
                    </div>
                </div>

                <form id="form-checkout" action="{{ route('checkout.process') }}" method="POST" class="p-6 lg:p-8 pb-32 lg:pb-8">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                        <!-- Dados do Cliente -->
                        <div class="space-y-6">
                            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                                <span class="mr-2 text-[#D4AF37]">👤</span> Dados Pessoais
                            </h2>
                            <div class="space-y-4">
                                <div>
                                    <label for="name" class="block text-gray-700 font-semibold mb-2">Nome Completo</label>
                                    <input type="text" name="name" id="name" required 
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-base focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all duration-300"
                                           placeholder="Digite seu nome completo">
                                </div>
                                <div>
                                    <label for="email" class="block text-gray-700 font-semibold mb-2">E-mail</label>
                                    <input type="email" name="email" id="email" required 
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-base focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all duration-300"
                                           placeholder="seu@email.com">
                                </div>
                                <div>
                                    <label for="cpf" class="block text-gray-700 font-semibold mb-2">CPF</label>
                                    <input type="text" name="cpf" id="cpf" required 
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-base focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all duration-300"
                                           placeholder="000.000.000-00">
                                </div>
                                <div>
                                    <label for="phone" class="block text-gray-700 font-semibold mb-2">Telefone</label>
                                    <input type="text" name="phone" id="phone" required 
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-base focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all duration-300"
                                           placeholder="(11) 99999-9999">
                                </div>
                                <div>
                                    <label for="address" class="block text-gray-700 font-semibold mb-2">Endereço</label>
                                    <input type="text" name="address" id="address" required 
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-base focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all duration-300"
                                           placeholder="Rua, número, complemento">
                                </div>
                                <div>
                                    <label for="zipcode" class="block text-gray-700 font-semibold mb-2">CEP</label>
                                    <input type="text" name="zipcode" id="zipcode" required 
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-base focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all duration-300"
                                           placeholder="00000-000">
                                </div>
                            </div>
                        </div>

                        <!-- Forma de Pagamento e Resumo -->
                        <div class="space-y-6">
                            <div>
                                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                                    <span class="mr-2 text-[#D4AF37]">💳</span> Forma de Pagamento
                                </h2>
                                <div class="space-y-3">
                                    <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-[#D4AF37] transition-all duration-300 has-[:checked]:bg-[#D4AF37]/5 has-[:checked]:border-[#D4AF37]">
                                        <input type="radio" name="payment_method" value="credit_card" class="h-4 w-4 text-[#D4AF37] focus:ring-[#D4AF37]">
                                        <span class="ml-3 text-base font-semibold text-gray-800">Cartão de Crédito</span>
                                    </label>
                                    <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-[#D4AF37] transition-all duration-300 has-[:checked]:bg-[#D4AF37]/5 has-[:checked]:border-[#D4AF37]">
                                        <input type="radio" name="payment_method" value="pix" class="h-4 w-4 text-[#D4AF37] focus:ring-[#D4AF37]" checked>
                                        <span class="ml-3 text-base font-semibold text-gray-800">PIX</span>
                                    </label>
                                </div>
                                
                                <div class="mt-4 bg-gray-50 border border-gray-200 rounded-lg p-4 flex items-start text-gray-700">
                                    <i class="fas fa-shield-alt text-2xl text-[#D4AF37] mr-3 mt-1"></i>
                                    <div>
                                        <h4 class="font-bold text-sm">Pagamento 100% Seguro</h4>
                                        <p class="text-xs text-gray-600 mt-1">Seus dados são criptografados e processados com segurança pelo Mercado Pago.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Formulário do Cartão de Crédito (escondido) -->
                            <div id="credit_card_form_container" class="hidden space-y-4">
                                <h3 class="text-lg font-semibold text-gray-800">Detalhes do Cartão</h3>
                                <div class="space-y-3">
                                    <div id="form-checkout__cardNumber-container"></div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div id="form-checkout__expirationDate-container"></div>
                                        <div id="form-checkout__securityCode-container"></div>
                                    </div>
                                    <div id="form-checkout__cardholderName-container"></div>
                                    <div id="form-checkout__identificationNumber-container"></div>
                                </div>
                                <input type="hidden" name="card_token" id="card_token">
                                <input type="hidden" name="payment_method_id" id="payment_method_id">
                            </div>
                        </div>
                    </div>

                    <!-- Desktop Order Summary -->
                    <div class="hidden lg:block mt-8">
                        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                            <span class="mr-2 text-[#D4AF37]">📋</span> Resumo do Pedido
                        </h2>
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-6">
                            @foreach($cartItems as $item)
                                @if($item->variant && $item->variant->product)
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center">
                                            <img src="{{ $item->variant->image_url ?? 'https://via.placeholder.com/40x40' }}" alt="{{ $item->variant->product->name }}" class="w-12 h-12 rounded-lg object-cover mr-3 border border-gray-200">
                                            <div>
                                                <div class="font-semibold text-gray-800">{{ $item->variant->product->name }}</div>
                                                <div class="text-sm text-gray-500">x{{ $item->quantity }}</div>
                                            </div>
                                        </div>
                                        <div class="font-semibold text-[#D4AF37]">R$ {{ number_format($item->price * $item->quantity, 2, ',', '.') }}</div>
                                    </div>
                                @endif
                            @endforeach
                            <div class="border-t border-gray-200 my-4"></div>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-semibold">R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Frete</span>
                                    <span class="font-semibold">R$ {{ number_format($shipping, 2, ',', '.') }}</span>
                                </div>
                                <div class="border-t border-gray-200 pt-2 flex justify-between">
                                    <span class="text-lg font-bold text-gray-800">Total</span>
                                    <span class="text-lg font-bold text-[#D4AF37]">R$ {{ number_format($total, 2, ',', '.') }}</span>
                                </div>
                            </div>
                            
                            <div class="text-center text-sm text-gray-500 mt-4 flex items-center justify-center">
                                <i class="fas fa-lock mr-2 text-gray-400"></i>
                                <span>Ambiente seguro e criptografado.</span>
                            </div>
                            <button type="submit" class="w-full text-center px-6 py-4 bg-[#D4AF37] hover:bg-[#B8941F] text-white rounded-full font-bold text-lg transition-all duration-300 flex items-center justify-center mt-4">
                                <span class="mr-2">💳</span> Finalizar Pedido
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Mobile Sticky Order Summary -->
        <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg z-50">
            <div class="px-4 py-4">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-sm text-gray-600">
                        <span class="font-semibold">{{ $cartItems->count() }}</span> item{{ $cartItems->count() > 1 ? 's' : '' }}
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-600">Total</div>
                        <div class="text-lg font-bold text-[#D4AF37]">R$ {{ number_format($total, 2, ',', '.') }}</div>
                    </div>
                </div>
                <button type="submit" form="form-checkout" class="w-full text-center px-6 py-3 bg-[#D4AF37] hover:bg-[#B8941F] text-white rounded-full font-bold text-lg transition-all duration-300 flex items-center justify-center">
                    <span class="mr-2">💳</span> Finalizar Pedido
                </button>
            </div>
        </div>
    </div>
    
    <style>
        .price { color: #D4AF37; font-weight: bold; }
        .btn-primary { background: #D4AF37; color: white; }
    </style>

    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        const mp = new MercadoPago("{{ env('MERCADO_PAGO_PUBLIC_KEY') }}", { locale: 'pt-BR' });
        
        function toggleCardForm(show) {
            document.getElementById('credit_card_form_container').classList.toggle('hidden', !show);
        }
        
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', (event) => {
                toggleCardForm(event.target.value === 'credit_card');
            });
        });
        
        toggleCardForm(document.querySelector('input[name="payment_method"]:checked').value === 'credit_card');

        // Inicializa os campos de cartão
        const cardNumber = mp.fields.create('cardNumber', { placeholder: "Número do Cartão" }).mount('form-checkout__cardNumber-container');
        const expirationDate = mp.fields.create('expirationDate', { placeholder: "MM/YY" }).mount('form-checkout__expirationDate-container');
        const securityCode = mp.fields.create('securityCode', { placeholder: "CVC" }).mount('form-checkout__securityCode-container');
        const cardholderName = mp.fields.create('cardholderName', { placeholder: "Nome do Titular" }).mount('form-checkout__cardholderName-container');
        const identificationNumber = mp.fields.create('identificationNumber', { placeholder: "CPF" }).mount('form-checkout__identificationNumber-container');

        const form = document.getElementById('form-checkout');
        form.addEventListener('submit', async (event) => {
            if (document.querySelector('input[name="payment_method"]:checked').value !== 'credit_card') {
                return; // Deixa o formulário ser enviado normalmente para o PIX
            }

            event.preventDefault();

            try {
                const { id: cardToken } = await mp.cardToken({
                    cardholderName: await cardholderName.getValue(),
                    identificationType: 'CPF',
                    identificationNumber: await identificationNumber.getValue(),
                    cardId: (await cardNumber.getCardId())?.id,
                });
                
                const { id: paymentMethodId } = await cardNumber.getPaymentMethod();

                document.getElementById('card_token').value = cardToken;
                document.getElementById('payment_method_id').value = paymentMethodId;

                form.submit();
            } catch (e) {
                console.error('Erro ao criar token do cartão', e);
                alert('Verifique os dados do seu cartão.');
            }
        });
    </script>
@endsection 