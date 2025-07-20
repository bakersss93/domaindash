<?php

namespace Tests\Feature;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationGenerationTest extends TestCase
{
    use RefreshDatabase;

    public function test_notification_is_listed_on_index(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        Notification::create([
            'user_id' => $user->id,
            'notification_type' => 'domain_expiry',
            'details' => ['domain' => 'example.com'],
            'is_read' => false,
        ]);

        $this->actingAs($user);
        $this->get('/notifications')
            ->assertSee('Domain_expiry')
            ->assertOk();
    }
}
