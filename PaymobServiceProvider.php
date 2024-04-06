<?php

namespace App\Providers;

use App\Http\Services\Paymob;
use Illuminate\Support\ServiceProvider;

class PaymobServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('Paymob', 'App\Http\Services\Paymob');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
