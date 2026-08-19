<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TiktokAccountController;
use App\Http\Controllers\Api\TiktokPostController;
use App\Http\Controllers\Api\TiktokAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    // Quản lý Tài khoản TikTok
    Route::apiResource('tiktok-accounts', TiktokAccountController::class);

    // Quản lý Bài đăng Video TikTok
    Route::apiResource('tiktok-posts', TiktokPostController::class);

    Route::post('tiktok-posts/{id}/publish', [TiktokPostController::class, 'publishNow']);
});

Route::prefix('v1/tiktok')->group(function () {
    // 1. Tạo Link Đăng nhập TikTok
    Route::get('/auth-url', [TiktokAuthController::class, 'getAuthUrl']);

    // 2. Nhận Code và Đổi lấy Token thật
    Route::get('/callback', [TiktokAuthController::class, 'handleCallback']);

    // 3. Làm mới Token khi Access Token hết hạn
    Route::post('/refresh-token/{account_id}', [TiktokAuthController::class, 'refreshToken']);


});