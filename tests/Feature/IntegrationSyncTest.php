<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\HaloClient;
use App\Services\ITGlueClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class IntegrationSyncTest extends TestCase
{
    use RefreshDatabase;

    public function test_linking_domain_triggers_external_sync(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);

        $halo = Mockery::mock(HaloClient::class);
        $halo->shouldReceive('upsertAsset')->once();
        $this->app->instance(HaloClient::class, $halo);

        $itglue = Mockery::mock(ITGlueClient::class);
        $itglue->shouldReceive('upsertConfiguration')->once();
        $this->app->instance(ITGlueClient::class, $itglue);

        $this->actingAs($admin)
            ->post('/domains', [
                'domain_name' => 'example.com',
                'customer_id' => $customer->id,
                'auto_renew' => true,
            ])->assertRedirect('/domains');
    }
}
