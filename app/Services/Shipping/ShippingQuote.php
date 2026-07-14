<?php

namespace App\Services\Shipping;

readonly class ShippingQuote
{
    public function __construct(
        public string $provider,
        public string $service,
        public float $price,
        public int $deadlineDays,
    ) {}
}
