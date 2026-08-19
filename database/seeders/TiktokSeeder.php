<?php

namespace Database\Seeders;

use App\Models\TiktokAccount;
use App\Models\TiktokPost;
use Illuminate\Database\Seeder;

class TiktokSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo 1 Tài khoản mẫu cố định để dễ test API
        $mainAccount = TiktokAccount::create([
            'account_name' => 'Kênh Main Official',
            'open_id' => 'user_open_id_123456',
            'client_key' => 'your_client_key_here',
            'client_secret' => 'your_client_secret_here',
            'access_token' => 'access_token_demo_sample',
            'access_token_expires_at' => now()->addDays(15),
            'refresh_token' => 'refresh_token_demo_sample',
            'refresh_token_expires_at' => now()->addDays(365),
            'default_post_time' => '19:30:00',
            'is_active' => true,
        ]);

        // Tạo bài post ngẫu nhiên cho kênh chính này
        TiktokPost::factory()->create([
            'tiktok_account_id' => $mainAccount->id,
            'title' => 'Video chạy vào tối nay #demo',
            'scheduled_at' => now()->addHours(2),
            'status' => 'pending',
        ]);

        TiktokPost::factory()->create([
            'tiktok_account_id' => $mainAccount->id,
            'title' => 'Video đã đăng thành công tuần trước',
            'scheduled_at' => now()->subDays(2),
            'status' => 'published',
            'publish_id' => 'v_pub_789101112',
            'published_at' => now()->subDays(2),
        ]);

        TiktokPost::factory()->create([
            'tiktok_account_id' => $mainAccount->id,
            'title' => 'Video bị lỗi hết hạn Token',
            'scheduled_at' => now()->subHours(5),
            'status' => 'failed',
            'error_message' => 'Access token has expired',
        ]);

        // 2. Tạo ngẫu nhiên thêm 3 Tài khoản khác, mỗi tài khoản kèm 5 video chờ đăng
        TiktokAccount::factory()
            ->count(3)
            ->has(TiktokPost::factory()->count(5), 'posts')
            ->create();
    }
}