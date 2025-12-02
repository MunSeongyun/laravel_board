<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{

    /**
     * post 목록 표시
     */
    public function index()
    {
        // 검색어가 있으면 Meilisearch에서 찾고, 없으면 그냥 DB 최신순

        $search = request('search');
        
        $posts = $search 
            ? Post::search($search)->paginate(20)   // search() 메서드는 Scout에서 제공
            : Post::latest()->paginate(20);
        
        return view('posts.index', compact('posts'));
    }

    /**
     * post 생성 폼 표시
     */
    public function create()
    {
        Gate::authorize('create', Post::class); // 권한 확인

        return view('posts.create');
    }

    /**
     * post 저장
     */
    public function store(StorePostRequest $request)
    {
        Gate::authorize('create', Post::class);

        $post = new Post($request->validated());
        $post->user_id = auth()->id(); // 현재 로그인한 사용자의 ID 할당
        $post->save();
        
        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * post 상세 표시
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * post 수정 폼 표시
     */
    public function edit(Post $post)
    {
        Gate::authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    /**
     * post 수정 처리
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        Gate::authorize('update', $post);

        $post->update($request->validated()); 

    
        return redirect()->route('posts.show', $post)->with('success', '글이 성공적으로 수정되었습니다.');
    }

    /**
     * post 삭제 처리
     */
    public function destroy(Post $post)
    {

        Gate::authorize('delete', $post);
        
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
