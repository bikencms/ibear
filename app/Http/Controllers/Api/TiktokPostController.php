<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TiktokPost;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Services\TikTokPostingService;
class TiktokPostController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = TiktokPost::with('account');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $posts = $query->orderBy('scheduled_at', 'desc')->paginate(15);
        return response()->json($posts);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tiktok_account_id' => 'required|exists:tiktok_accounts,id',
            'title' => 'required|string|max:2200', // TikTok giới hạn max 2200 ký tự
            'video' => 'required_without:video_path|file|mimes:mp4,mov,webm|max:512000', // Max 500MB
            'video_path' => 'required_without:video|string',
            'privacy_level' => 'nullable|in:PUBLIC_TO_EVERYONE,MUTUAL_FOLLOW_FRIENDS,FOLLOWER_OF_CREATOR,SELF_ONLY',
            'disable_duet' => 'nullable|boolean',
            'disable_stitch' => 'nullable|boolean',
            'disable_comment' => 'nullable|boolean',
            'brand_organic_toggle' => 'nullable|boolean',
            'brand_content_toggle' => 'nullable|boolean',
            'scheduled_at' => 'required|date|after:now',
        ]);

        // Đẩy video lên Storage nếu đính kèm file
        if ($request->hasFile('video')) {
            $path = $request->file('video')->store('tiktok_videos', 'public');
            $validated['video_path'] = Storage::disk('public')->url($path);
        }

        $post = TiktokPost::create($validated);

        return response()->json([
            'message' => 'Tạo lịch đăng TikTok thành công',
            'data' => $post
        ], 201);
    }

    public function show(TiktokPost $tiktokPost): JsonResponse
    {
        return response()->json(['data' => $tiktokPost->load('account')]);
    }

    public function update(Request $request, TiktokPost $tiktokPost): JsonResponse
    {
        // Chỉ cho sửa nếu bài viết ở trạng thái chờ
        if ($tiktokPost->status !== 'pending') {
            return response()->json([
                'message' => 'Không thể chỉnh sửa bài viết đã hoặc đang xử lý!'
            ], 422);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:2200',
            'privacy_level' => 'sometimes|in:PUBLIC_TO_EVERYONE,MUTUAL_FOLLOW_FRIENDS,FOLLOWER_OF_CREATOR,SELF_ONLY',
            'disable_duet' => 'sometimes|boolean',
            'disable_stitch' => 'sometimes|boolean',
            'disable_comment' => 'sometimes|boolean',
            'scheduled_at' => 'sometimes|date|after:now',
        ]);

        $tiktokPost->update($validated);

        return response()->json([
            'message' => 'Cập nhật thành công',
            'data' => $tiktokPost
        ]);
    }

    public function destroy(TiktokPost $tiktokPost): JsonResponse
    {
        if ($tiktokPost->status === 'processing') {
            return response()->json([
                'message' => 'Không thể xóa bài viết đang đẩy lên TikTok!'
            ], 422);
        }

        $tiktokPost->delete();
        return response()->json(['message' => 'Đã xóa bài viết']);
    }

    public function publishNow(int $id, Request $request, TikTokPostingService $postingService): JsonResponse
    {
        $post = TiktokPost::with('account')->findOrFail($id);

        // Cập nhật URL Ngrok mới vào đây
        $redirectUri = $request->input('redirect_uri', 'https://spirits-enviable-pyramid.ngrok-free.dev/api/v1/tiktok/callback');

        try {
            $result = $postingService->processPost($post, $redirectUri);

            return response()->json([
                'success' => true,
                'data' => $result,
                'post' => $post->fresh()
            ]);
        } catch (\Exception $e) {
            if (str_starts_with($e->getMessage(), 'ACCOUNT_NOT_AUTHORIZED:')) {
                $authUrl = str_replace('ACCOUNT_NOT_AUTHORIZED:', '', $e->getMessage());

                return response()->json([
                    'success' => false,
                    'need_authorization' => true,
                    'message' => 'Tài khoản chưa được liên kết hoặc Token hết hạn. Vui lòng truy cập auth_url để đăng nhập TikTok.',
                    'auth_url' => $authUrl
                ], 401);
            }

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}