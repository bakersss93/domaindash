<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ITGlueClient;

class ITGlueServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ITGlueClient::class, fn () => new ITGlueClient());
    }
}
