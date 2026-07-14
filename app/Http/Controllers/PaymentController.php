<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function return(Request $request): View
    {
        return view('pages.payment-return', [
            'status' => $request->query('status', 'pending'),
        ]);
    }
}
