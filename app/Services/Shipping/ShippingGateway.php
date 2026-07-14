<?php

namespace App\Services\Shipping;

use App\Exceptions\ShippingUnavailableException;
use Illuminate\Support\Collection;

interface ShippingGateway
{
    /**
     * @param  array<int, array{weight_grams:int, height_cm:int, width_cm:int, length_cm:int, quantity:int}>  $items
     * @return Collection<int, ShippingQuote>
     *
     * @throws ShippingUnavailableException quando o provedor está indisponível, o CEP é inválido,
     *                                      ou algum item não possui peso/dimensões cadastrados
     */
    public function quote(string $originZip, string $destinationZip, array $items): Collection;
}
