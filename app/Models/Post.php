<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use App\Policies\PostPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;

#[UsePolicy(PostPolicy::class)] // 모델에 정책 연결 (없어도 됨)
class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory, SoftDeletes, HasRichText;

    protected $fillable = [
        'title',
        'user_id',
        'content'
    ];

    // 리치 텍스트 속성 지정해서 자동으로 content가 TrixRichText 모델로 처리되도록 함
    protected $richTextAttributes = [
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
