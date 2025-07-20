<?php

namespace Database\Factories;

use App\Models\ApiKey;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ApiKeyFactory extends Factory
{
    protected $model = ApiKey::class;

    public function definition()
    {
        return [
            'key_name' => $this->faker->word,
            'description' => null,
            'hashed_key' => hash('sha256', Str::random(32)),
            'permissions' => 'read-only',
            'allowed_ips' => null,
            'rate_limit' => 100,
            'expires_at' => null,
        ];
    }
}
