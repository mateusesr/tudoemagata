<?php

namespace App\Services\Shipping;

use App\Exceptions\ShippingUnavailableException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MelhorEnvioGateway implements ShippingGateway
{
    public function quote(string $originZip, string $destinationZip, array $items): Collection
    {
        foreach ($items as $item) {
            if (empty($item['weight_grams']) || empty($item['height_cm']) || empty($item['width_cm']) || empty($item['length_cm'])) {
                throw new ShippingUnavailableException(
                    'Um ou mais produtos não possuem peso/dimensões cadastrados. Entre em contato pelo WhatsApp para calcular o frete manualmente.'
                );
            }
        }

        try {
            $response = Http::baseUrl(config('services.melhor_envio.base_url'))
                ->withToken(config('services.melhor_envio.token'))
                ->acceptJson()
                ->post('/api/v2/me/shipment/calculate', [
                    'from' => ['postal_code' => $this->onlyDigits($originZip)],
                    'to' => ['postal_code' => $this->onlyDigits($destinationZip)],
                    'products' => collect($items)->map(fn (array $item) => [
                        'weight' => $item['weight_grams'] / 1000,
                        'height' => $item['height_cm'],
                        'width' => $item['width_cm'],
                        'length' => $item['length_cm'],
                        'quantity' => $item['quantity'],
                    ])->all(),
                ]);
        } catch (\Throwable $exception) {
            Log::warning('Falha ao consultar frete no Melhor Envio.', ['message' => $exception->getMessage()]);

            throw new ShippingUnavailableException;
        }

        if ($response->failed()) {
            Log::warning('Melhor Envio retornou erro na cotação de frete.', ['status' => $response->status(), 'body' => $response->body()]);

            throw new ShippingUnavailableException;
        }

        $quotes = collect($response->json())
            ->reject(fn (array $option) => isset($option['error']))
            ->map(fn (array $option) => new ShippingQuote(
                provider: $option['company']['name'] ?? 'Transportadora',
                service: $option['name'] ?? 'Frete',
                price: (float) ($option['price'] ?? 0),
                deadlineDays: (int) ($option['delivery_time'] ?? 0),
            ))
            ->values();

        if ($quotes->isEmpty()) {
            throw new ShippingUnavailableException('Nenhuma opção de frete disponível para este CEP.');
        }

        return $quotes;
    }

    protected function onlyDigits(string $value): string
    {
        return preg_replace('/\D/', '', $value);
    }
}
