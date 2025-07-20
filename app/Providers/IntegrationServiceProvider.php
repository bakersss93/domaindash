<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\HaloPSAClient;
use App\Services\ITGlueClient;

class IntegrationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(HaloPSAClient::class, fn () => new HaloPSAClient());
        $this->app->alias(HaloPSAClient::class, 'halopsa');

        $this->app->singleton(ITGlueClient::class, fn () => new ITGlueClient());
        $this->app->alias(ITGlueClient::class, 'itglue');
    }
}
