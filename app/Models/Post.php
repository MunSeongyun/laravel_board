<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\UploadedFile;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use App\Policies\PostPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Laravel\Scout\Searchable; // Laravel Scout의 Searchable 트레이트 추가(멜리서치 사용 시 필요)
use App\Services\FileService;

#[UsePolicy(PostPolicy::class)] // 모델에 정책 연결 (없어도 됨)
class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory, SoftDeletes, HasRichText, Searchable;

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

    public function uploadedFiles()
    {
        // 다형성 관계 설정
        // 첫 번째 인자: 최종 목적지 모델 (UploadedFile)
        // 두 번째 인자: 다형성 관계 이름 (morphs 메서드에 지정한 이름)
        return $this->morphMany(UploadedFile::class, 'fileable');
    }

    // Laravel Scout를 사용하여 검색 가능하도록 설정
    public function toSearchableArray()
    {
        $this->load('user'); 

        return [
            'title' => $this->title,
            'author_name' => $this->user->name ?? '', 
        ];
    }

    // 모델 이벤트 사용
    protected static function booted()
    {
        // 포스트가 영구삭제될 때 관련된 업로드된 파일들도 함께 삭제
        static::forceDeleting(function ($post) {
            $fileService = app(FileService::class);
            // 익명함수에서 외부 변수 사용시 use() 필요
            $post->uploadedFiles()->withTrashed()->get()->each(function ($file) use ($fileService) {
                $fileService->forceDelete($file);
            });
        });

        static::deleting(function ($post) {
            // 이미 영구 삭제(forceDelete) 중이라면 deleting 이벤트는 무시
            if ($post->isForceDeleting()) {
                return;
            }
            $fileService = app(FileService::class);
            $post->uploadedFiles->each(function ($file) use ($fileService) {
                $fileService->delete($file);
            });
        });

        static::restored(function ($post) {
            $fileService = app(FileService::class);

            // 이미 삭제된(Trashed) 파일들만 골라서 복구
            $post->uploadedFiles()->onlyTrashed()->get()->each(function ($file) use ($fileService) {
                $fileService->restore($file);
            });
        });
    }
}
