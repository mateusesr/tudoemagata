<?php

namespace App\Providers;

use App\Listeners\CreateCustomerRecordListener;
use App\Listeners\MergeGuestCartListener;
use App\Services\Shipping\MelhorEnvioGateway;
use App\Services\Shipping\ShippingGateway;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ShippingGateway::class, MelhorEnvioGateway::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(Registered::class, CreateCustomerRecordListener::class);
        Event::listen(Login::class, MergeGuestCartListener::class);
    }
}
