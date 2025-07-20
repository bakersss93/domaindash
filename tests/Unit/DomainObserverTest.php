<?php

namespace Tests\Unit;

use App\Models\Domain;
use App\Observers\DomainObserver;
use App\Services\HaloPSAClient;
use App\Services\ITGlueClient;
use Illuminate\Support\Facades\Event;
use Carbon\Carbon;
use Tests\TestCase;

class DomainObserverTest extends TestCase
{
    public function test_saved_triggers_integration_calls(): void
    {
        $domain = new Domain(['domain_name' => 'example.com', 'customer_id' => 1, 'renewal_date' => Carbon::parse('2024-01-01')]);
        $domain->syncOriginal();
        $domain->customer_id = 2;
        $domain->renewal_date = Carbon::parse('2025-01-01');
        $domain->syncChanges();

        $halo = \Mockery::mock(HaloPSAClient::class);
        $halo->shouldReceive('createOrUpdateAsset')->once();
        $halo->shouldReceive('updateExpiry')->once();

        $itglue = \Mockery::mock(ITGlueClient::class);
        $itglue->shouldReceive('createOrUpdateConfiguration')->once();
        $itglue->shouldReceive('updateExpiry')->once();

        Event::fake();

        $observer = new DomainObserver($halo, $itglue);
        $observer->saved($domain);

        Event::assertDispatched(\App\Events\AutomationWebhook::class, 2);
    }
}
