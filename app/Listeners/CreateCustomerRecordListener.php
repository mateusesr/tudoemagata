<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;

class CreateCustomerRecordListener
{
    public function handle(Registered $event): void
    {
        $event->user->customer()->firstOrCreate([], ['customer_type' => 'retail']);
    }
}
