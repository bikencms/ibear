<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TiktokAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_name',
        'open_id',
        'client_key',
        'client_secret',
        'access_token',
        'access_token_expires_at',
        'refresh_token',
        'refresh_token_expires_at',
        'default_post_time',
        'is_active',
    ];

    protected $casts = [
        'access_token_expires_at' => 'datetime',
        'refresh_token_expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Tránh lộ client_secret hoặc tokens khi serialize ra JSON nếu cần
    protected $hidden = [
        'client_secret',
        'access_token',
        'refresh_token',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(TiktokPost::class);
    }
}