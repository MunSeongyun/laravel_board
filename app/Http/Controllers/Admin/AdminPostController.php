<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class AdminPostController extends Controller
{

    /**
     * 파라미터를 Post $post로 받으면 삭제된 글은 조회할 수 없기 때문에
     * int $id로 받음
     */
    public function show(int $id)
    {
        $post = Post::withTrashed()->findOrFail($id);

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

    public function restore(int $id)
    {
        Gate::authorize('restore', Post::class);   // 권한 확인

        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore(); // 글 복원

        return redirect()->route('posts.trashed')->with('success', '글이 성공적으로 복원되었습니다.');
    }

    public function forceDelete(int $id)
    {
        Gate::authorize('forceDelete', Post::class);  // 권한 확인
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->forceDelete(); // 영구 삭제

        return redirect()->route('posts.trashed')->with('success', '글이 성공적으로 삭제되었습니다.');
    }
}
