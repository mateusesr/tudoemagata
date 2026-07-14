<?php

namespace App\Exceptions;

use Exception;

class ShippingUnavailableException extends Exception
{
    public function __construct(string $message = 'Não foi possível calcular o frete no momento.')
    {
        parent::__construct($message);
    }
}
