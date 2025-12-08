<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminCommentController;
use App\Http\Controllers\AttachmentImageController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    // posts.index 뷰로 리다이렉트
    return redirect()->route('posts.index');
});

// can:admin 미들웨어를 사용해서 AppServiceProvider에서 정의한 'admin' 권한을 확인
Route::middleware(['auth', 'can:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('admin/posts', [AdminPostController::class, 'trashed'])->name('posts.trashed');
    Route::get('admin/posts/{adminPost}', [AdminPostController::class, 'show'])->name('posts.adminShow');
    Route::patch('admin/posts/{adminPost}', [AdminPostController::class, 'restore'])->name('posts.restore');
    Route::delete('admin/posts/{adminPost}', [AdminPostController::class, 'forceDelete'])->name('posts.forceDelete');
    Route::get('admin/posts/attachment/{adminFile}', [AdminPostController::class, 'downloadDeletedAttachment'])->name('posts.downloadDeletedAttachment');

    Route::patch('admin/comments/{adminComment}', [AdminCommentController::class, 'restore'])->name('comments.restore');
    Route::delete('admin/comments/{adminComment}', [AdminCommentController::class, 'forceDelete'])->name('comments.forceDelete');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/posts/{post}/comments',[CommentController::class,'store'])->name('posts.comments.store');

    // 댓글 수정, 삭제는 댓글 ID만으로 가능하므로 shallow routing 적용
    // shallow(): 부모 리소스 식별자가 필요 없는 경로를 생성
    // 예: update, destroy 메서드에서는 /comments/{comment} 경로만 사용
    // index, create, store 메서드에서는 /posts/{post}/comments 경로 사용
    Route::resource('comments', CommentController::class)->only([
        'update', 'destroy'
    ])->shallow();

    Route::resource('posts', PostController::class)
        ->except(['index', 'show']);

    Route::post('/attachments', AttachmentImageController::class)->name('posts.imageStore');
});

Route::resource('posts', PostController::class)
    ->only(['index', 'show']);
Route::get('/attachments/{file}', [PostController::class, 'downloadAttachment'])->name('posts.downloadAttachment');

require __DIR__.'/auth.php';
