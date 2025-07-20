<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\HaloClient;

class HaloServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(HaloClient::class, fn () => new HaloClient());
    }
}
