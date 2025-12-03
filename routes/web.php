<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\AttachmentImageController;

Route::get('/', function () {
    return view('welcome');
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
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('posts', PostController::class)->names([
        'index' => 'posts.index'
    ]);
    Route::post('/attachments', AttachmentImageController::class)->name('posts.imageStore');
    Route::get('/attachments/{file}', [PostController::class, 'downloadAttachment'])->name('posts.downloadAttachment');
});



require __DIR__.'/auth.php';
