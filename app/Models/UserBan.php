<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBan extends Model
{
    /** @use HasFactory<\Database\Factories\UserBanFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'banned_until',
        'reason',
    ];

    protected $casts = [
        'banned_until' => 'datetime',
    ];
}
