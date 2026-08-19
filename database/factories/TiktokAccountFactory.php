<?php

namespace Database\Factories;

use App\Models\TiktokAccount;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TiktokAccountFactory extends Factory
{
    protected $model = TiktokAccount::class;

    public function definition(): array
    {
        return [
            'account_name' => 'TikTok Channel ' . $this->faker->firstName(),
            'open_id' => Str::random(16),
            'client_key' => 'aw' . Str::random(14),
            'client_secret' => Str::random(32),
            'access_token' => 'act.' . Str::random(40),
            'access_token_expires_at' => now()->addDays(15),
            'refresh_token' => 'rft.' . Str::random(40),
            'refresh_token_expires_at' => now()->addDays(365),
            'default_post_time' => $this->faker->randomElement(['08:00:00', '12:00:00', '19:00:00', '21:00:00']),
            'is_active' => true,
        ];
    }
}