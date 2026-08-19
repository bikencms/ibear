<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tiktok_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tiktok_account_id')->constrained('tiktok_accounts')->onDelete('cascade');
            
            $table->string('title');
            $table->string('video_path');
            
            // Cấu hình linh hoạt khi đẩy sang TikTok API
            $table->enum('privacy_level', [
                'PUBLIC_TO_EVERYONE', 
                'MUTUAL_FOLLOW_FRIENDS', 
                'FOLLOWER_OF_CREATOR', 
                'SELF_ONLY'
            ])->default('PUBLIC_TO_EVERYONE');

            $table->boolean('disable_duet')->default(false);
            $table->boolean('disable_stitch')->default(false);
            $table->boolean('disable_comment')->default(false);
            $table->boolean('brand_organic_toggle')->default(false);
            $table->boolean('brand_content_toggle')->default(false);

            // Quản lý lịch chạy
            $table->timestamp('scheduled_at');
            $table->enum('status', ['pending', 'processing', 'published', 'failed'])->default('pending');
            
            $table->string('publish_id')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
            
            $table->index(['status', 'scheduled_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiktok_posts');
    }
};