<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory, SoftDeletes, HasRichText;

    protected $fillable = [
        'title',
        'user_id',
        'content'
    ];

    protected $richTextAttributes = [
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
