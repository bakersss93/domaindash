<?php

namespace Tests\Feature;

use Tests\TestCase;

class OAuthLoginTest extends TestCase
{
    public function test_google_redirect(): void
    {
        $response = $this->get('/auth/google');
        $response->assertStatus(302);
    }
}

