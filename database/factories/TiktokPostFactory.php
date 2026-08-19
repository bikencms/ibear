<?php

namespace Database\Factories;

use App\Models\TiktokAccount;
use App\Models\TiktokPost;
use Illuminate\Database\Eloquent\Factories\Factory;

class TiktokPostFactory extends Factory
{
    protected $model = TiktokPost::class;

    public function definition(): array
    {
        return [
            'tiktok_account_id' => TiktokAccount::factory(),
            'title' => $this->faker->sentence(8) . ' #xuhuong #trending #viral',
            'video_path' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4',
            'privacy_level' => $this->faker->randomElement([
                'PUBLIC_TO_EVERYONE',
                'MUTUAL_FOLLOW_FRIENDS',
                'FOLLOWER_OF_CREATOR',
                'SELF_ONLY'
            ]),
            'disable_duet' => false,
            'disable_stitch' => false,
            'disable_comment' => false,
            'brand_organic_toggle' => false,
            'brand_content_toggle' => false,
            'scheduled_at' => $this->faker->dateTimeBetween('now', '+7 days'),
            'status' => 'pending',
            'publish_id' => null,
            'error_message' => null,
            'published_at' => null,
        ];
    }
}