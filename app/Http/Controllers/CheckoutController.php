<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Common\RequestOptions;

class CheckoutController extends Controller
{
    public function __construct()
    {
        // Inicializa o SDK do Mercado Pago
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));
    }

    /**
     * Display the checkout form.
     */
    public function index()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        
        if (!$cart || $cart->items()->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Seu carrinho está vazio!');
        }

        $cartItems = $cart->items()->with(['variant.product'])->get();
        
        $subtotal = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });
        
        $shipping = $subtotal > 200 ? 0 : 25.00; // Frete grátis acima de R$200
        $total = $subtotal + $shipping;

        return view('checkout', compact('cartItems', 'subtotal', 'shipping', 'total'));
    }

    /**
     * Process the checkout.
     */
    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'cpf' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'zipcode' => 'required|string|max:10',
            'payment_method' => 'required|string|in:credit_card,pix',
        ]);

        if ($request->payment_method === 'pix') {
            return $this->processPix($request);
        }

        if ($request->payment_method === 'credit_card') {
            return $this->processCreditCard($request);
        }

        return redirect()->back()->with('error', 'Método de pagamento inválido.');
    }

    private function processPix(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Seu carrinho está vazio!');
        }

        $cartItems = $cart->items->load(['product']);

        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
        $shipping = $subtotal > 200 ? 0 : 25.00;
        $total = $subtotal + $shipping;

        $address = \App\Models\Address::create([
            'user_id' => $user->id,
            'name' => $request->name, 'phone' => $request->phone,
            'full_address' => $request->address, 'zip_code' => $request->zipcode,
        ]);

        $order = Order::create([
            'user_id' => $user->id, 
            'address_id' => $address->id,
            'status' => 'pending', 
            'total' => $total,
            'shipping_cost' => $shipping,
            'payment_method' => 'pix',
        ]);

        $name_parts = explode(' ', $request->name, 2);
        $first_name = $name_parts[0];
        $last_name = $name_parts[1] ?? '';
        
        $cpf = preg_replace('/[^0-9]/', '', $request->cpf);

        $paymentClient = new PaymentClient();
        $payment = $paymentClient->create([
            "transaction_amount" => round($total, 2),
            "description" => "Pedido #" . $order->id . " - " . config('app.name'),
            "payment_method_id" => "pix",
            "payer" => [
                "email" => $request->email,
                "first_name" => $first_name,
                "last_name" => $last_name,
                "identification" => [
                    "type" => "CPF",
                    "number" => $cpf
                ]
            ]
        ]);
        
        $order->payment_id = $payment->id;
        $order->save();

        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->product_id, 
                'product_variant_id' => $item->product_variant_id,
                'quantity' => $item->quantity, 
                'price' => $item->price
            ]);
        }
        $cart->items()->delete();

        session(['pix_qr_code' => $payment->point_of_interaction->transaction_data->qr_code_base64, 'pix_qr_code_text' => $payment->point_of_interaction->transaction_data->qr_code]);

        return redirect()->route('orders.show', $order)->with('success', 'Pedido realizado! Pague com Pix para confirmar.');
    }

    private function processCreditCard(Request $request)
    {
        // Lógica para processar pagamento com Cartão de Crédito
    }
} 