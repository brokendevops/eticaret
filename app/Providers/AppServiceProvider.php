<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\OrderPlaced;
use App\Listeners\SendOrderConfirmation;
use App\Listeners\UpdateProductStock;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Event Listener Kayıtlar
        Event::listen(OrderPlaced::class, SendOrderConfirmation::class);
        Event::listen(OrderPlaced::class, UpdateProductStock::class);
    }
}
