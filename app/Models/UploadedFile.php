<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Post;

class UploadedFile extends Model
{
    /** @use HasFactory<\Database\Factories\UploadedFileFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'file_path',
        'file_name'
    ];

    public function fileable()
    {
        return $this->morphTo();
    }
}
