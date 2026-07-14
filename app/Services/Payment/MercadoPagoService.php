<?php

namespace App\Services\Payment;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MercadoPagoService
{
    public function createPreference(Order $order): array
    {
        $items = $order->items->map(fn ($item) => [
            'title' => $item->product_name.($item->variant_name ? " - {$item->variant_name}" : ''),
            'quantity' => $item->quantity,
            'unit_price' => (float) $item->unit_price,
            'currency_id' => 'BRL',
        ]);

        if ((float) $order->shipping_total > 0) {
            $items->push([
                'title' => 'Frete'.($order->shipping_service ? " ({$order->shipping_service})" : ''),
                'quantity' => 1,
                'unit_price' => (float) $order->shipping_total,
                'currency_id' => 'BRL',
            ]);
        }

        $response = Http::withToken(config('services.mercadopago.access_token'))
            ->post('https://api.mercadopago.com/checkout/preferences', [
                'items' => $items->all(),
                'external_reference' => (string) $order->id,
                'back_urls' => [
                    'success' => route('checkout.payment.return', ['status' => 'success']),
                    'failure' => route('checkout.payment.return', ['status' => 'failure']),
                    'pending' => route('checkout.payment.return', ['status' => 'pending']),
                ],
                'auto_return' => 'approved',
                'notification_url' => route('api.mercadopago.webhook'),
            ])
            ->throw()
            ->json();

        $order->payment()->updateOrCreate([], [
            'provider' => 'mercado_pago',
            'provider_payment_id' => $response['id'] ?? null,
            'status' => 'pending',
            'amount' => $order->grand_total,
            'payload' => $response,
        ]);

        Log::info('Preferência de pagamento criada no Mercado Pago.', ['order_id' => $order->id, 'preference_id' => $response['id'] ?? null]);

        return $response;
    }

    public function findPayment(string $paymentId): array
    {
        return Http::withToken(config('services.mercadopago.access_token'))
            ->get("https://api.mercadopago.com/v1/payments/{$paymentId}")
            ->throw()
            ->json();
    }
}
