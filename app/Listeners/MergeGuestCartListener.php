<?php

namespace App\Listeners;

use App\Models\Cart;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Session;

class MergeGuestCartListener
{
    public function handle(Login $event): void
    {
        $guestCart = Cart::query()->where('session_id', Session::getId())->first();

        if (! $guestCart) {
            return;
        }

        $userCart = Cart::query()->firstOrCreate(['user_id' => $event->user->id]);

        foreach ($guestCart->items as $guestItem) {
            $userItem = $userCart->items()->where('product_variant_id', $guestItem->product_variant_id)->first();

            if ($userItem) {
                $userItem->update(['quantity' => $userItem->quantity + $guestItem->quantity]);
            } else {
                $guestItem->update(['cart_id' => $userCart->id]);
            }
        }

        $guestCart->delete();
    }
}
