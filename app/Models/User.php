<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // 사용자가 업로드한 모든 파일을 가져오는 메서드
    public function uploadedFiles()
    {
        // 두 번째 인자(Post::class)를 통해, 
        // 최종적으로 UploadedFile을 가져오는데, 
        // UploadedFile의 연결 키는 'fileable_id'이고, 
        // 그 타입은 Post::class 인 것만 가져와라.
        return $this->hasManyThrough(
            UploadedFile::class, 
            Post::class, 
            'user_id',     // Post 테이블의 외래 키 (users테이블을 가리킴)
            'fileable_id'  // UploadedFile 테이블의 외래 키 (posts테이블을 가리킴)
        )
        ->where('fileable_type', Post::class); // 중요: Post에 연결된 파일만 한정
    }

    // 관리자 여부 확인
    public function is_admin() : bool {
        return $this->email === env('ADMIN_EMAIL', 'testadmin@g.yju.ac.kr');
    }
}
