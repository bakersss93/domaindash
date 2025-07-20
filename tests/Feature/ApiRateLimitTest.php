<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ApiRateLimitTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Route::middleware('throttle:2,1')->get('/throttle-test', fn () => 'ok');
    }

    public function test_throttle_blocks_after_limit(): void
    {
        $this->get('/throttle-test')->assertOk();
        $this->get('/throttle-test')->assertOk();
        $this->get('/throttle-test')->assertStatus(429);
    }
}
