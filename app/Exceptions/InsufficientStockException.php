<?php

namespace App\Exceptions;

use Exception;

class InsufficientStockException extends Exception
{
    public function __construct(string $message = 'Quantidade indisponível em estoque.')
    {
        parent::__construct($message);
    }
}
