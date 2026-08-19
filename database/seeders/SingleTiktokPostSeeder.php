<?php

namespace Database\Seeders;

use App\Models\TiktokAccount;
use App\Models\TiktokPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SingleTiktokPostSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Lấy hoặc tạo mới 1 tài khoản TikTok mẫu
        $account = TiktokAccount::firstOrCreate(
            ['client_key' => 'aw1234567890demo'],
            [
                'account_name' => 'Kênh Test Storage Local',
                'open_id' => 'user_open_id_demo',
                'client_secret' => 'secret_demo_123456',
                'access_token' => 'act.demo_access_token_sample',
                'access_token_expires_at' => now()->addDays(15),
                'refresh_token' => 'rft.demo_refresh_token_sample',
                'refresh_token_expires_at' => now()->addDays(365),
                'default_post_time' => '19:00:00',
                'is_active' => true,
            ]
        );

        // 2. Tạo file video mẫu giả lập nằm trong storage/app/public/tiktok_videos
        $fileName = 'sample_video_' . time() . '.mp4';
        $relativeStoragePath = 'tiktok_videos/' . $fileName;

        // Tạo nội dung file mẫu nếu chưa tồn tại
        if (!Storage::disk('public')->exists($relativeStoragePath)) {
            Storage::disk('public')->put($relativeStoragePath, 'fake_video_bytes_content');
        }

        // Lấy Public URL tuyệt đối (VD: https://domain.com/storage/tiktok_videos/sample_video_xxx.mp4)
        $videoUrl = Storage::disk('public')->url($relativeStoragePath);

        // 3. Tạo 1 record duy nhất trong bảng tiktok_posts
        $post = TiktokPost::create([
            'tiktok_account_id' => $account->id,
            'title' => 'Video thử nghiệm đăng từ Storage Laravel #xuhuong #laravel #api',
            'video_path' => $videoUrl, // Đường dẫn URL public để TikTok gọi PULL_FROM_URL
            'privacy_level' => 'PUBLIC_TO_EVERYONE',
            'disable_duet' => false,
            'disable_stitch' => false,
            'disable_comment' => false,
            'brand_organic_toggle' => false,
            'brand_content_toggle' => false,
            'scheduled_at' => now()->addMinutes(10),
            'status' => 'pending',
            'publish_id' => null,
            'error_message' => null,
        ]);

        $this->command->info("--- TẠO RECORD THÀNH CÔNG ---");
        $this->command->info("Post ID: {$post->id}");
        $this->command->info("Video Public URL: {$videoUrl}");
    }
}