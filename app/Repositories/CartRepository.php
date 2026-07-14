<?php

namespace App\Repositories;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartRepository
{
    public function resolveCurrent(): Cart
    {
        if (Auth::check()) {
            return Cart::query()->firstOrCreate(['user_id' => Auth::id()]);
        }

        return Cart::query()->firstOrCreate(['session_id' => Session::getId()]);
    }

    public function findForCurrentOwner(int $cartId): ?Cart
    {
        $query = Cart::query();

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', Session::getId());
        }

        return $query->find($cartId);
    }
}
