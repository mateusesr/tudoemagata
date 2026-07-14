<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/busca', SearchController::class)->name('search');
Route::get('/categoria/{slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/produto/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/carrinho', [CartController::class, 'show'])->name('cart.show');
Route::post('/carrinho/itens', [CartController::class, 'store'])->name('cart.items.store');
Route::patch('/carrinho/itens/{cartItem}', [CartController::class, 'update'])->name('cart.items.update');
Route::delete('/carrinho/itens/{cartItem}', [CartController::class, 'destroy'])->name('cart.items.destroy');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/frete', [CheckoutController::class, 'quoteShipping'])->name('checkout.shipping.quote');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});

Route::get('/checkout/retorno', [PaymentController::class, 'return'])->name('checkout.payment.return');

Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');

require __DIR__.'/auth.php';
