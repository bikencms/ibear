<?php
namespace App\Services;

use App\Models\TiktokAccount;
use App\Models\TiktokPost;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class TikTokPostingService
{
    protected string $baseUrl = 'https://open.tiktokapis.com/v2';

    /**
     * Kiểm tra và tự động làm mới Token, hoặc yêu cầu liên kết nếu chưa có
     */
    public function ensureValidToken(TiktokAccount $account, string $redirectUri): void
    {
        // 1. Kiểm tra nếu chưa có Token HOẶC Token vẫn đang là Token Demo/Mẫu từ Seeder
        $isDemoToken = str_contains($account->access_token ?? '', 'demo');

        if ((!$account->access_token && !$account->refresh_token) || $isDemoToken) {
            $authUrl = $this->generateAuthUrl($account, $redirectUri);
            throw new Exception("ACCOUNT_NOT_AUTHORIZED:" . $authUrl);
        }

        // 2. Nếu Access Token hết hạn nhưng CÓ Refresh Token thật -> Tự làm mới Token
        if ($account->access_token_expires_at && $account->access_token_expires_at->isPast()) {
            if (!$account->refresh_token || str_contains($account->refresh_token, 'demo')) {
                $authUrl = $this->generateAuthUrl($account, $redirectUri);
                throw new Exception("ACCOUNT_NOT_AUTHORIZED:" . $authUrl);
            }

            $response = Http::asForm()->post("{$this->baseUrl}/oauth/token/", [
                'client_key' => $account->client_key,
                'client_secret' => $account->client_secret,
                'grant_type' => 'refresh_token',
                'refresh_token' => $account->refresh_token,
            ]);

            $data = $response->json();

            if ($response->failed() || isset($data['error'])) {
                $authUrl = $this->generateAuthUrl($account, $redirectUri);
                throw new Exception("ACCOUNT_NOT_AUTHORIZED:" . $authUrl);
            }

            // Lưu Access Token + Refresh Token mới
            $account->update([
                'access_token' => $data['access_token'],
                'access_token_expires_at' => now()->addSeconds($data['expires_in'] ?? 86400),
                'refresh_token' => $data['refresh_token'] ?? $account->refresh_token,
                'refresh_token_expires_at' => now()->addSeconds($data['refresh_expires_in'] ?? 31536000),
            ]);
        }
    }

    /**
     * Sinh URL Đăng nhập TikTok
     */
    public function generateAuthUrl(TiktokAccount $account, string $redirectUri): string
    {
        $scopes = ['user.info.basic', 'video.upload', 'video.publish'];

        return "https://www.tiktok.com/v2/auth/authorize/?" . http_build_query([
            'client_key' => $account->client_key,
            'scope' => implode(',', $scopes),
            'response_type' => 'code',
            'redirect_uri' => $redirectUri,
            'state' => $account->id,
        ]);
    }

    /**
     * Xử lý chính
     */
    public function processPost(TiktokPost $post, string $redirectUri): array
    {
        $account = $post->account;

        if (!$account) {
            throw new Exception("Không tìm thấy tài khoản TikTok liên kết.");
        }

        // 1. Kiểm tra / Tự động Refresh Token
        $this->ensureValidToken($account, $redirectUri);

        // 1. Lấy Creator Info: Bắt buộc truyền body là một mảng rỗng [] (tương đương JSON {})
        $creatorResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $account->access_token,
            'Content-Type'  => 'application/json; charset=UTF-8',
        ])->withBody('{}', 'application/json')
        ->post("{$this->baseUrl}/post/publish/creator_info/query/");

        $creatorData = $creatorResponse->json();

        // TikTok trả về code = "ok" nghĩa là THÀNH CÔNG, chỉ báo lỗi nếu code != "ok"
        if ($creatorResponse->failed() || ($creatorData['error']['code'] ?? '') !== 'ok') {
            $errorMsg = $creatorData['error']['message'] ?? $creatorResponse->body();
            throw new Exception('Lỗi lấy Creator Info TikTok: ' . $errorMsg);
        }

        $creatorInfo = $creatorData['data'] ?? [];
        $allowedPrivacyOptions = $creatorInfo['privacy_level_options'] ?? [];

        // Tự động điều chỉnh privacy_level hợp lệ theo quyền của Kênh
        if (!empty($allowedPrivacyOptions) && !in_array($post->privacy_level, $allowedPrivacyOptions)) {
            $post->privacy_level = $allowedPrivacyOptions[0];
        }

        // 1. Chuyển đổi về đường dẫn tuyệt đối trên máy/server
        $relativePath = $post->video_path; // "app/public/tiktok_videos/sample_video_1787131696.mp4"

        // Nếu chuỗi bắt đầu bằng 'app/public/', loại bỏ nó để ghép chuẩn với storage_path('app/public/...')
        if (str_starts_with($relativePath, 'app/public/')) {
            $relativePath = substr($relativePath, 11);
        }

        $videoPath = storage_path('app/public/' . ltrim($relativePath, '/'));

        // 2. Kiểm tra file tồn tại
        if (!file_exists($videoPath)) {
            throw new \Exception("Không tìm thấy file video tại: " . $videoPath);
        }
        $fileSize = file_exists($videoPath) ? filesize($videoPath) : 0;

        // 1. Kiểm tra privacy_level: Bắt buộc dùng SELF_ONLY nếu đang ở môi trường Test/Sandbox
        $privacyLevel = $post->privacy_level;

        // Nếu app chưa Live hoặc gặp lỗi Guidelines, ép về SELF_ONLY để đăng thử nghiệm
        if ($privacyLevel === 'PUBLIC_TO_EVERYONE') {
            $privacyLevel = 'SELF_ONLY'; 
        }

        // 1. Kích thước 1 Chunk chuẩn tối đa: 64 MB = 64 * 1024 * 1024 bytes
        $maxChunkSizeBytes = 67108864; 

        if ($fileSize < $maxChunkSizeBytes) {
            // Với file < 64MB (như file 8MB của bạn): Gửi 1 Chunk duy nhất
            $initChunkSize = $fileSize;
            $totalChunkCount = 1;
        } else {
            // Với file >= 64MB: Cố định chunk_size là 64MB
            $initChunkSize = $maxChunkSizeBytes;
            $totalChunkCount = (int) ceil($fileSize / $maxChunkSizeBytes);
        }

        // 2. Payload Init gửi sang TikTok API
        $payload = [
            'post_info' => [
                'title'           => (string) $post->title,
                'privacy_level'   => "SELF_ONLY",
                'disable_duet'    => (bool) ($creatorInfo['duet_disabled'] ?? $post->disable_duet),
                'disable_stitch'  => (bool) ($creatorInfo['stitch_disabled'] ?? $post->disable_stitch),
                'disable_comment' => (bool) ($creatorInfo['comment_disabled'] ?? $post->disable_comment),
            ],
            'source_info' => [
                'source'            => 'FILE_UPLOAD',
                'video_size'        => (int) $fileSize,
                'chunk_size'        => (int) $initChunkSize,    // Đúng bằng fileSize với file < 64MB
                'total_chunk_count' => (int) $totalChunkCount, // Đúng bằng 1 với file < 64MB
            ],
        ];

        Log::info('payload', ['payload' => $payload]);

        // 3. Gọi API Init Session
        $initResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $account->access_token,
            'Content-Type'  => 'application/json; charset=UTF-8',
        ])->post("{$this->baseUrl}/post/publish/video/init/", $payload);

        $initData = $initResponse->json();

        if ($initResponse->failed() || ($initData['error']['code'] ?? '') !== 'ok') {
            throw new \Exception('Lỗi Init Upload TikTok: ' . ($initData['error']['message'] ?? $initResponse->body()));
        }

        $uploadUrl = $initData['data']['upload_url'];
        $publishId = $initData['data']['publish_id'];

        // 4. Đọc file và PUT từng Chunk lên TikTok Upload Server
        $fileHandle = fopen($videoPath, 'rb');

        for ($i = 0; $i < $totalChunkCount; $i++) {
            $startByte = $i * $initChunkSize;
            $bytesToRead = min($initChunkSize, $fileSize - $startByte);
            $endByte = $startByte + $bytesToRead - 1;

            fseek($fileHandle, $startByte);
            $chunkData = fread($fileHandle, $bytesToRead);

            $chunkResponse = Http::withHeaders([
                'Content-Type'   => 'video/mp4',
                'Content-Length' => $bytesToRead,
                'Content-Range'  => "bytes {$startByte}-{$endByte}/{$fileSize}",
            ])->withBody($chunkData, 'video/mp4')
            ->put($uploadUrl);

            if ($chunkResponse->failed()) {
                fclose($fileHandle);
                throw new \Exception("Lỗi Upload Chunk " . ($i + 1) . "/" . $totalChunkCount . ": " . $chunkResponse->body());
            }
        }

        fclose($fileHandle);

        // 5. Cập nhật bài viết thành công
        $post->update([
            'status'        => 'processing',
            'publish_id'    => $publishId,
            'error_message' => null,
        ]);

        return [
            'publish_id' => $publishId,
            'status'     => 'processing',
            'message'    => 'Đã upload video thành công lên TikTok!',
        ];
    }
}