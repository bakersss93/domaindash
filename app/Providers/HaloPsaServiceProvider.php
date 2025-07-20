<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\HaloPsaClient;

class HaloPsaServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(HaloPsaClient::class, fn () => new HaloPsaClient());
        $this->app->alias(HaloPsaClient::class, 'halo');
    }
}
