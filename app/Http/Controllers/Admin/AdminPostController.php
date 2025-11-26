<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class AdminPostController extends Controller
{

    public function show(int $id)
    {
        $post = Post::withTrashed()->findOrFail($id);

        return view('posts.show', compact('post'));
    }

    public function trashed()
    {
        Gate::authorize('restore', Post::class);
        $posts = Post::onlyTrashed()->latest()->paginate(20);
        return view('admin.post-index', compact('posts'));
    }

    public function restore(int $id)
    {
        Gate::authorize('restore', Post::class);

        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->route('posts.trashed')->with('success', '글이 성공적으로 복원되었습니다.');
    }

    public function forceDelete(int $id)
    {
        Gate::authorize('forceDelete', Post::class);
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->forceDelete();

        return redirect()->route('posts.trashed')->with('success', '글이 성공적으로 삭제되었습니다.');
    }
}
