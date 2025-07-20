<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Domain;
use App\Models\HostingService;
use App\Models\SSLService;
use App\Observers\DomainObserver;
use App\Observers\HostingServiceObserver;
use App\Observers\SSLServiceObserver;

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
        Domain::observe(DomainObserver::class);
        HostingService::observe(HostingServiceObserver::class);
        SSLService::observe(SSLServiceObserver::class);
    }
}
