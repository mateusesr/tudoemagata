<?php

namespace App\Services;

use App\Exceptions\InsufficientStockException;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use App\Repositories\CartRepository;

class CartService
{
    public function __construct(protected CartRepository $repository) {}

    public function current(): Cart
    {
        return $this->repository->resolveCurrent();
    }

    public function addItem(Cart $cart, ProductVariant $variant, int $quantity): CartItem
    {
        $existing = $cart->items()->where('product_variant_id', $variant->id)->first();
        $desiredQuantity = ($existing?->quantity ?? 0) + $quantity;

        if ($variant->availableQuantity() < $desiredQuantity) {
            throw new InsufficientStockException("Apenas {$variant->availableQuantity()} unidade(s) disponível(is) para {$variant->name}.");
        }

        return CartItem::query()->updateOrCreate(
            ['cart_id' => $cart->id, 'product_variant_id' => $variant->id],
            ['quantity' => $desiredQuantity]
        );
    }

    public function updateItemQuantity(CartItem $item, int $quantity): CartItem
    {
        if ($quantity < 1) {
            $item->delete();

            return $item;
        }

        $variant = $item->variant;

        if ($variant->availableQuantity() < $quantity) {
            throw new InsufficientStockException("Apenas {$variant->availableQuantity()} unidade(s) disponível(is) para {$variant->name}.");
        }

        $item->update(['quantity' => $quantity]);

        return $item;
    }

    public function removeItem(CartItem $item): void
    {
        $item->delete();
    }

    public function getSummary(Cart $cart): array
    {
        $cart->load('items.variant.product', 'items.variant.images');

        $items = $cart->items->map(function (CartItem $item) {
            $subtotal = $item->variant->price * $item->quantity;

            return [
                'id' => $item->id,
                'product_variant_id' => $item->product_variant_id,
                'product_name' => $item->variant->product->name,
                'variant_name' => $item->variant->name,
                'unit_price' => $item->variant->price,
                'quantity' => $item->quantity,
                'subtotal' => $subtotal,
                'available_quantity' => $item->variant->availableQuantity(),
            ];
        });

        return [
            'items' => $items,
            'total' => $items->sum('subtotal'),
            'count' => $items->sum('quantity'),
        ];
    }
}
