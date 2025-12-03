<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Services\FileService;

class AdminPostController extends Controller
{
    /**
     * 특정 삭제된 글 상세 보기
     */
    public function show(Post $post)
    {
        Gate::authorize('restore', Post::class);

        $post->load(['uploadedFiles' => function ($query) {
                $query->withTrashed();
            }, 'comments' => function ($query) {
                $query->withTrashed();
                $query->with(['user' => function ($userQuery) {
                    $userQuery->withTrashed();
                }]);
            }]);
    
        return view('posts.show', compact('post'));
    }

    /**
     * 삭제된 글 목록
     */
    public function trashed()
    {
        Gate::authorize('restore', Post::class); // 복구 할 수 있는 사람만 접근 가능
        $posts = Post::onlyTrashed()->latest()->paginate(20); // onlyTrashed 메서드로 삭제된 글만 조회
        return view('admin.post-index', compact('posts'));
    }

    public function restore(Post $post)
    {
        Gate::authorize('restore', Post::class);   // 권한 확인

        $post->restore(); // 글 복원

        return redirect()->route('posts.trashed')->with('success', __('Post has been restored.'));
    }

    public function forceDelete(Post $post)
    {
        Gate::authorize('forceDelete', Post::class);  // 권한 확인
        $post->forceDelete(); // 영구 삭제

        return redirect()->route('posts.trashed')->with('success', __('Post has been permanently deleted.'));
    }

    /**
     * 삭제된 첨부파일 다운로드 처리
     */
    public function downloadDeletedAttachment(UploadedFile $file, FileService $fileService)
    {
        Gate::authorize('restore', Post::class); 
        return $fileService->download($file);
    }
}
