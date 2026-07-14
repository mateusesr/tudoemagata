<?php

namespace App\Http\Controllers;

use App\Exceptions\InsufficientStockException;
use App\Models\CartItem;
use App\Models\ProductVariant;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService) {}

    protected function ensureItemBelongsToCurrentCart(CartItem $cartItem): void
    {
        abort_unless($cartItem->cart_id === $this->cartService->current()->id, Response::HTTP_FORBIDDEN);
    }

    public function show(): View
    {
        $cart = $this->cartService->current();

        return view('pages.cart', [
            'summary' => $this->cartService->getSummary($cart),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'product_variant_id' => ['required', 'integer', 'exists:product_variants,id'],
            'quantity' => ['sometimes', 'integer', 'min:1'],
        ]);

        $variant = ProductVariant::query()->findOrFail($data['product_variant_id']);
        $cart = $this->cartService->current();

        try {
            $this->cartService->addItem($cart, $variant, $data['quantity'] ?? 1);
        } catch (InsufficientStockException $exception) {
            return response()->json(['message' => $exception->getMessage()], 422);
        }

        return response()->json(['summary' => $this->cartService->getSummary($cart)]);
    }

    public function update(Request $request, CartItem $cartItem): JsonResponse
    {
        $this->ensureItemBelongsToCurrentCart($cartItem);

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        try {
            $this->cartService->updateItemQuantity($cartItem, $data['quantity']);
        } catch (InsufficientStockException $exception) {
            return response()->json(['message' => $exception->getMessage()], 422);
        }

        return response()->json(['summary' => $this->cartService->getSummary($this->cartService->current())]);
    }

    public function destroy(CartItem $cartItem): JsonResponse
    {
        $this->ensureItemBelongsToCurrentCart($cartItem);

        $this->cartService->removeItem($cartItem);

        return response()->json(['summary' => $this->cartService->getSummary($this->cartService->current())]);
    }
}
