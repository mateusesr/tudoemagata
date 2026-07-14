<?php

namespace App\Console\Commands;

use App\Services\InventoryReservationService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:release-expired-reservations')]
#[Description('Libera reservas de estoque expiradas sem confirmação de pagamento')]
class ReleaseExpiredReservations extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(InventoryReservationService $reservationService)
    {
        $count = $reservationService->releaseExpired();

        $this->info("{$count} reserva(s) expirada(s) liberada(s).");
    }
}
