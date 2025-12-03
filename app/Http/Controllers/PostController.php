<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\UploadedFile;
use Illuminate\Support\Facades\Gate;
use App\Services\FileService;
use Illuminate\Support\Facades\Storage;

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
    public function store(StorePostRequest $request, FileService $fileService)
    {
        Gate::authorize('create', Post::class);
        
        $postData = $request->safe()->except('uploaded_files');
        $files = $request->safe()->only(['uploaded_files']);
        
        $post = $request->user()->posts()->create($postData);
        
        if(!empty($files['uploaded_files'])){
            foreach($files['uploaded_files'] as $file){
                $fileService->upload($file, $post, 'posts');
            }
        }
        
        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * post 상세 표시
     */
    public function show(Post $post)
    {
        // 1. 관리자인지 확인
        if (auth()->user()?->can('restore', $post)) {
            // withTrashed()를 사용하여 삭제된 파일도 포함해서 로드
            $post->load(['uploadedFiles' => function ($query) {
                $query->withTrashed();
            }]);
        } else {
            // 일반 사용자는 정상 파일만 로드
            $post->load('uploadedFiles');
        }

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
    public function update(UpdatePostRequest $request, Post $post, FileService $fileService)
    {
        Gate::authorize('update', $post);

        $postData = $request->safe()->except(['uploaded_files', 'delete_files']);
        $fileData = $request->safe()->only(['uploaded_files']);
        $deleteData = $request->safe()->only(['delete_files']);

        $post->update($postData); 

        if(!empty($fileData['uploaded_files'])){
            foreach($fileData['uploaded_files'] as $file){
                $fileService->upload($file, $post, 'posts');
            }
        }

        if(!empty($deleteData['delete_files'])){
            $filesToDelete = $post->uploadedFiles()->whereIn('id', $deleteData['delete_files'])->get();
            foreach($filesToDelete as $file){
                $fileService->delete($file);
            }
        }
    
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

    /**
     * 첨부파일 다운로드 처리
     */
    public function downloadAttachment(UploadedFile $file, FileService $fileService)
    {
        return $fileService->download($file);
    }

    
}
