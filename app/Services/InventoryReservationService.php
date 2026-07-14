<?php

namespace App\Services;

use App\Models\InventoryReservation;
use App\Models\Order;
use App\Models\ProductVariant;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InventoryReservationService
{
    public function reserve(ProductVariant $variant, Order $order, int $quantity, Carbon $expiresAt): InventoryReservation
    {
        return InventoryReservation::create([
            'product_variant_id' => $variant->id,
            'order_id' => $order->id,
            'quantity' => $quantity,
            'status' => 'active',
            'expires_at' => $expiresAt,
        ]);
    }

    public function convert(InventoryReservation $reservation): void
    {
        DB::transaction(function () use ($reservation) {
            $variant = ProductVariant::query()->lockForUpdate()->findOrFail($reservation->product_variant_id);

            $newBalance = $variant->stock_quantity - $reservation->quantity;
            $variant->update(['stock_quantity' => max(0, $newBalance)]);

            StockMovement::create([
                'product_variant_id' => $variant->id,
                'order_id' => $reservation->order_id,
                'type' => 'sale_deduction',
                'quantity' => -$reservation->quantity,
                'balance_after' => max(0, $newBalance),
            ]);

            $reservation->update(['status' => 'converted']);
        });
    }

    public function release(InventoryReservation $reservation, string $note): void
    {
        DB::transaction(function () use ($reservation, $note) {
            $variant = ProductVariant::query()->lockForUpdate()->findOrFail($reservation->product_variant_id);

            StockMovement::create([
                'product_variant_id' => $variant->id,
                'order_id' => $reservation->order_id,
                'type' => 'release',
                'quantity' => 0,
                'balance_after' => $variant->stock_quantity,
                'note' => $note,
            ]);

            $reservation->update([
                'status' => 'released',
                'released_at' => now(),
            ]);
        });
    }

    public function releaseExpired(): int
    {
        $expired = InventoryReservation::query()
            ->where('status', 'active')
            ->where('expires_at', '<=', now())
            ->get();

        foreach ($expired as $reservation) {
            $this->release($reservation, 'Expirado sem confirmação de pagamento.');
        }

        return $expired->count();
    }
}
