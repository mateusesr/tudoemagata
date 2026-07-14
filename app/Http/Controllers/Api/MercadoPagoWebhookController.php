<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InventoryReservation;
use App\Models\Payment;
use App\Services\InventoryReservationService;
use App\Services\Payment\MercadoPagoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MercadoPagoWebhookController extends Controller
{
    protected const array APPROVED_STATUSES = ['approved'];

    protected const array FAILED_STATUSES = ['rejected', 'cancelled', 'expired'];

    public function __construct(
        protected MercadoPagoService $mercadoPagoService,
        protected InventoryReservationService $reservationService,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $paymentId = $request->input('data.id');

        if (! $paymentId || $request->input('type') !== 'payment') {
            return response()->json(['message' => 'ignored'], 200);
        }

        try {
            $paymentData = $this->mercadoPagoService->findPayment($paymentId);
        } catch (\Throwable $exception) {
            Log::warning('Falha ao buscar pagamento no Mercado Pago via webhook.', ['payment_id' => $paymentId, 'message' => $exception->getMessage()]);

            return response()->json(['message' => 'error fetching payment'], 200);
        }

        $orderId = $paymentData['external_reference'] ?? null;

        if (! $orderId) {
            return response()->json(['message' => 'no external_reference'], 200);
        }

        DB::transaction(function () use ($paymentData, $orderId) {
            $payment = Payment::query()->lockForUpdate()->where('order_id', $orderId)->first();

            if (! $payment) {
                Log::warning('Webhook do Mercado Pago recebido para pedido sem payment associado.', ['order_id' => $orderId]);

                return;
            }

            $newStatus = $paymentData['status'] ?? 'pending';

            if ($payment->status === 'approved' && $newStatus === 'approved') {
                return;
            }

            $payment->update([
                'provider_payment_id' => $paymentData['id'] ?? $payment->provider_payment_id,
                'method' => $this->mapPaymentMethod($paymentData),
                'status' => $newStatus,
                'payload' => $paymentData,
                'paid_at' => $newStatus === 'approved' ? now() : $payment->paid_at,
            ]);

            $order = $payment->order;

            if (in_array($newStatus, self::APPROVED_STATUSES, true)) {
                $order->update(['status' => 'paid', 'paid_at' => now()]);

                InventoryReservation::query()
                    ->where('order_id', $order->id)
                    ->where('status', 'active')
                    ->each(fn (InventoryReservation $reservation) => $this->reservationService->convert($reservation));
            } elseif (in_array($newStatus, self::FAILED_STATUSES, true)) {
                InventoryReservation::query()
                    ->where('order_id', $order->id)
                    ->where('status', 'active')
                    ->each(fn (InventoryReservation $reservation) => $this->reservationService->release($reservation, "Pagamento {$newStatus}."));
            }
        });

        return response()->json(['message' => 'processed'], 200);
    }

    protected function mapPaymentMethod(array $paymentData): ?string
    {
        $paymentTypeId = $paymentData['payment_type_id'] ?? null;

        return match ($paymentTypeId) {
            'pix' => 'pix',
            'credit_card' => 'credit_card',
            default => null,
        };
    }
}
