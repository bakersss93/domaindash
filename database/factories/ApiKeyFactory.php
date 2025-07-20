<?php

namespace Database\Factories;

use App\Models\ApiKey;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ApiKeyFactory extends Factory
{
    protected $model = ApiKey::class;

    public function definition(): array
    {
        return [
            'key_name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'hashed_key' => hash('sha256', 'testtoken'),
            'permissions' => 'read-only',
            'allowed_ips' => null,
            'rate_limit' => 60,
            'expires_at' => now()->addDay(),
        ];
    }
}
