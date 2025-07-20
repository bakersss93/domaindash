<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Route;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Tests\TestCase;

class DomainSyncJobTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Route::get('/sync-domains', function () {
            DomainSyncJob::dispatch();
        });
    }

    public function test_domain_sync_job_dispatched(): void
    {
        Bus::fake();
        $this->get('/sync-domains');

        Bus::assertDispatched(DomainSyncJob::class);
    }
}

class DomainSyncJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        // Domain sync logic
    }
}
