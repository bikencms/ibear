<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TiktokAccount;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TiktokAccountController extends Controller
{
    public function index(): JsonResponse
    {
        $accounts = TiktokAccount::withCount('posts')->get();
        return response()->json(['data' => $accounts]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'account_name' => 'required|string|max:255',
            'client_key' => 'required|string',
            'client_secret' => 'required|string',
            'default_post_time' => 'nullable|date_format:H:i:s',
        ]);

        $account = TiktokAccount::create($validated);

        return response()->json([
            'message' => 'Thêm tài khoản thành công',
            'data' => $account
        ], 201);
    }

    public function show(TiktokAccount $tiktokAccount): JsonResponse
    {
        return response()->json(['data' => $tiktokAccount]);
    }

    public function update(Request $request, TiktokAccount $tiktokAccount): JsonResponse
    {
        $validated = $request->validate([
            'account_name' => 'sometimes|string|max:255',
            'client_key' => 'sometimes|string',
            'client_secret' => 'sometimes|string',
            'access_token' => 'nullable|string',
            'refresh_token' => 'nullable|string',
            'default_post_time' => 'nullable|date_format:H:i:s',
            'is_active' => 'sometimes|boolean',
        ]);

        $tiktokAccount->update($validated);

        return response()->json([
            'message' => 'Cập nhật thành công',
            'data' => $tiktokAccount
        ]);
    }

    public function destroy(TiktokAccount $tiktokAccount): JsonResponse
    {
        $tiktokAccount->delete();
        return response()->json(['message' => 'Xóa tài khoản thành công']);
    }
}