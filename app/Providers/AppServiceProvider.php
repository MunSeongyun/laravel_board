<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use App\Models\Comment;
use App\Models\UploadedFile;
use Illuminate\Support\Facades\Route;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 관리자 권한 게이트 정의
        Gate::define('admin', function ($user) {
            return $user->is_admin();
        });

        // 관리자용 Post 바인딩: 삭제된 글 조회
        Route::bind('adminPost', function ($value) {
            return Post::withTrashed()->findOrFail($value);
        });
        // 관리자용 UploadedFile 바인딩: 삭제된 첨부파일 조회
        Route::bind('adminFile', function ($value) {
            return UploadedFile::withTrashed()->findOrFail($value);
        });
        Route::bind('adminComment', function ($value) {
            return Comment::withTrashed()->findOrFail($value);
        });
        Route::bind('adminUser', function ($value) {
            return User::withTrashed()->findOrFail($value);
        });
    }
}
