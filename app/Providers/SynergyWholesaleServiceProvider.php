<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SynergyClient;

class SynergyWholesaleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(SynergyClient::class, fn() => new SynergyClient());
        $this->app->alias(SynergyClient::class, 'synergy');
    }
}
