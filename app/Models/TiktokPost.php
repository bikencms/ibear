<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TiktokPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'tiktok_account_id',
        'title',
        'video_path',
        'privacy_level',
        'disable_duet',
        'disable_stitch',
        'disable_comment',
        'brand_organic_toggle',
        'brand_content_toggle',
        'scheduled_at',
        'status',
        'publish_id',
        'error_message',
        'published_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'published_at' => 'datetime',
        'disable_duet' => 'boolean',
        'disable_stitch' => 'boolean',
        'disable_comment' => 'boolean',
        'brand_organic_toggle' => 'boolean',
        'brand_content_toggle' => 'boolean',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(TiktokAccount::class, 'tiktok_account_id');
    }
}