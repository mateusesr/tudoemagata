<?php

use App\Http\Controllers\Api\MercadoPagoWebhookController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']);

Route::post('/webhooks/mercadopago', MercadoPagoWebhookController::class)->name('api.mercadopago.webhook');
