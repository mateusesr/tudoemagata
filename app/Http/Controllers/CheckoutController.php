<?php

namespace App\Http\Controllers;

use App\Exceptions\ShippingUnavailableException;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\ProductVariant;
use App\Services\CartService;
use App\Services\InventoryReservationService;
use App\Services\Payment\MercadoPagoService;
use App\Services\Shipping\ShippingGateway;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected ShippingGateway $shippingGateway,
        protected InventoryReservationService $reservationService,
        protected MercadoPagoService $mercadoPagoService,
    ) {}

    public function show(): View
    {
        $customer = auth()->user()->customer()->firstOrCreate([], ['customer_type' => 'retail']);
        $cart = $this->cartService->current();

        return view('pages.checkout', [
            'addresses' => $customer->addresses,
            'summary' => $this->cartService->getSummary($cart),
        ]);
    }

    public function storeAddress(Request $request): JsonResponse
    {
        $data = $request->validate([
            'recipient_name' => ['required', 'string', 'max:255'],
            'zip_code' => ['required', 'string', 'max:9'],
            'street' => ['required', 'string', 'max:255'],
            'number' => ['required', 'string', 'max:20'],
            'complement' => ['nullable', 'string', 'max:255'],
            'neighborhood' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'size:2'],
        ]);

        $customer = auth()->user()->customer()->firstOrCreate([], ['customer_type' => 'retail']);

        $address = $customer->addresses()->create([
            ...$data,
            'is_default' => $customer->addresses()->doesntExist(),
        ]);

        return response()->json(['address' => $address]);
    }

    public function quoteShipping(Request $request): JsonResponse
    {
        $data = $request->validate([
            'zip_code' => ['required', 'string'],
        ]);

        $cart = $this->cartService->current();
        $cart->load('items.variant');

        $items = $cart->items->map(fn ($item) => [
            'weight_grams' => $item->variant->weight_grams,
            'height_cm' => $item->variant->height_cm,
            'width_cm' => $item->variant->width_cm,
            'length_cm' => $item->variant->length_cm,
            'quantity' => $item->quantity,
        ])->all();

        try {
            $quotes = $this->shippingGateway->quote(
                config('services.melhor_envio.from_zip_code'),
                $data['zip_code'],
                $items
            );
        } catch (ShippingUnavailableException $exception) {
            return response()->json(['message' => $exception->getMessage()], 422);
        }

        return response()->json([
            'quotes' => $quotes->map(fn ($quote) => [
                'provider' => $quote->provider,
                'service' => $quote->service,
                'price' => $quote->price,
                'deadline_days' => $quote->deadlineDays,
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'customer_address_id' => ['required', 'integer', 'exists:customer_addresses,id'],
            'shipping_provider' => ['required', 'string'],
            'shipping_service' => ['required', 'string'],
            'shipping_price' => ['required', 'numeric'],
            'shipping_deadline_days' => ['required', 'integer'],
        ]);

        $customer = auth()->user()->customer()->firstOrCreate([], ['customer_type' => 'retail']);
        $address = CustomerAddress::query()
            ->where('customer_id', $customer->id)
            ->findOrFail($data['customer_address_id']);

        $cart = $this->cartService->current();
        $cart->load('items.variant.product');

        abort_if($cart->items->isEmpty(), 422, 'Carrinho vazio.');

        $itemsTotal = $cart->items->sum(fn ($item) => $item->variant->price * $item->quantity);
        $shippingTotal = (float) $data['shipping_price'];

        $order = DB::transaction(function () use ($customer, $address, $cart, $data, $itemsTotal, $shippingTotal) {
            $order = Order::create([
                'order_number' => 'PED-'.now()->format('Ymd').'-'.Str::upper(Str::random(6)),
                'customer_id' => $customer->id,
                'customer_address_id' => $address->id,
                'shipping_recipient_name' => $address->recipient_name,
                'shipping_zip_code' => $address->zip_code,
                'shipping_street' => $address->street,
                'shipping_number' => $address->number,
                'shipping_complement' => $address->complement,
                'shipping_neighborhood' => $address->neighborhood,
                'shipping_city' => $address->city,
                'shipping_state' => $address->state,
                'status' => 'pending',
                'shipping_provider' => $data['shipping_provider'],
                'shipping_service' => $data['shipping_service'],
                'shipping_deadline_days' => $data['shipping_deadline_days'],
                'items_total' => $itemsTotal,
                'shipping_total' => $shippingTotal,
                'grand_total' => $itemsTotal + $shippingTotal,
            ]);

            foreach ($cart->items as $cartItem) {
                $variant = ProductVariant::query()->lockForUpdate()->findOrFail($cartItem->product_variant_id);

                abort_unless($variant->availableQuantity() >= $cartItem->quantity, 422, "Item indisponível: {$variant->name}.");

                $primaryImage = $variant->product->images->firstWhere('is_primary', true)
                    ?? $variant->images->first()
                    ?? $variant->product->images->first();

                $order->items()->create([
                    'product_variant_id' => $variant->id,
                    'product_name' => $variant->product->name,
                    'variant_name' => $variant->name,
                    'sku' => $variant->sku,
                    'image_path' => $primaryImage?->path,
                    'unit_price' => $variant->price,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $variant->price * $cartItem->quantity,
                ]);

                $this->reservationService->reserve($variant, $order, $cartItem->quantity, now()->addMinutes(30));
            }

            $cart->items()->delete();

            return $order;
        });

        $preference = $this->mercadoPagoService->createPreference($order);

        return redirect()->away($preference['init_point']);
    }
}
