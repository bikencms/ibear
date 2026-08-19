<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TiktokAccount;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TiktokAuthController extends Controller
{
    /**
     * API 1: Lấy URL để chuyển hướng người dùng sang TikTok đăng nhập & cấp quyền
     * GET /api/v1/tiktok/auth-url?account_id=1
     */
    public function getAuthUrl(Request $request): JsonResponse
    {
        $request->validate([
            'account_id' => 'required|exists:tiktok_accounts,id',
            'redirect_uri' => 'required|url',
        ]);

        $account = TiktokAccount::findOrFail($request->account_id);

        $scopes = [
            'user.info.basic',
            'video.upload',
            'video.publish',
        ];

        // Tạo link cấp quyền theo chuẩn TikTok OAuth2
        $authUrl = "https://www.tiktok.com/v2/auth/authorize/?" . http_build_query([
            'client_key' => $account->client_key,
            'scope' => implode(',', $scopes),
            'response_type' => 'code',
            'redirect_uri' => $request->redirect_uri,
            'state' => $account->id, // Gửi kèm account_id làm state để nhận diện ở callback
        ]);

        return response()->json([
            'auth_url' => $authUrl,
        ]);
    }

    /**
     * API 2: Nhận Auth Code từ TikTok và dùng Client Key + Client Secret đổi lấy Access Token
     * POST /api/v1/tiktok/callback
     */
    public function handleCallback(Request $request)
    {
        $code = $request->query('code');
        $accountId = $request->query('state');

        if (!$code) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy authorization code.'], 400);
        }

        $account = TiktokAccount::find($accountId);
        if (!$account) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy account ID: ' . $accountId], 404);
        }

        // ĐẢM BẢO redirect_uri KHỚP EXACT 100% VỚI LINK ĐÃ CẤU HÌNH TRÊN TIKTOK PORTAL
        $redirectUri = 'https://spirits-enviable-pyramid.ngrok-free.dev/api/v1/tiktok/callback';

        $response = Http::asForm()->post('https://open.tiktokapis.com/v2/oauth/token/', [
            'client_key'     => trim($account->client_key),
            'client_secret'  => trim($account->client_secret),
            'code'           => trim($code),
            'grant_type'     => 'authorization_code',
            'redirect_uri'   => $redirectUri,
        ]);

        $data = $response->json();

        if ($response->failed() || isset($data['error'])) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi đổi Access Token từ TikTok',
                'error'   => $data
            ], 400);
        }

        // Lưu Real Access Token & Refresh Token vào DB
        $account->update([
            'open_id'                 => $data['open_id'] ?? $account->open_id,
            'access_token'            => $data['access_token'],
            'access_token_expires_at' => now()->addSeconds($data['expires_in'] ?? 86400),
            'refresh_token'           => $data['refresh_token'] ?? $account->refresh_token,
            'refresh_token_expires_at' => now()->addSeconds($data['refresh_expires_in'] ?? 31536000),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Ủy quyền thành công! Real Token đã được lưu vào Database.',
            'data'    => [
                'account_id'   => $account->id,
                'access_token' => $account->access_token,
                'expires_at'   => $account->access_token_expires_at,
            ]
        ]);
    }

    /**
     * API 3: Làm mới Access Token khi hết hạn bằng Refresh Token
     * POST /api/v1/tiktok/refresh-token/{account_id}
     */
    public function refreshToken(int $accountId): JsonResponse
    {
        $account = TiktokAccount::findOrFail($accountId);

        if (!$account->refresh_token) {
            return response()->json(['message' => 'Tài khoản chưa có Refresh Token!'], 400);
        }

        $response = Http::asForm()->post('https://open.tiktokapis.com/v2/oauth/token/', [
            'client_key' => $account->client_key,
            'client_secret' => $account->client_secret,
            'grant_type' => 'refresh_token',
            'refresh_token' => $account->refresh_token,
        ]);

        $data = $response->json();

        if ($response->failed() || isset($data['error'])) {
            return response()->json([
                'message' => 'Làm mới Token thất bại!',
                'error' => $data['error_description'] ?? 'Lỗi không xác định',
            ], 400);
        }

        $account->update([
            'access_token' => $data['access_token'],
            'access_token_expires_at' => now()->addSeconds($data['expires_in'] ?? 86400),
            'refresh_token' => $data['refresh_token'] ?? $account->refresh_token,
            'refresh_token_expires_at' => now()->addSeconds($data['refresh_expires_in'] ?? 31536000),
        ]);

        return response()->json([
            'message' => 'Làm mới Access Token thành công!',
            'access_token_expires_at' => $account->access_token_expires_at,
        ]);
    }
}