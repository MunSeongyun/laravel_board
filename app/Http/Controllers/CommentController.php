<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, Post $post)
    {
        Gate::authorize('create', Comment::class);
        $commentData = $request->safe()->only(['content']);
        $post->comments()->create(array_merge($commentData, [
            'user_id' => $request->user()->id,
        ]));

        // 처리가 끝나면 이전 페이지(게시글 상세)로 돌려보냄
        return back()->with('success', __('Comment has been posted.'));
    }   

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        Gate::authorize('update', $comment);
        $commentData = $request->safe()->only(['content']);
        $comment->update($commentData);

        return back()->with('success', __('Comment has been updated.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        Gate::authorize('delete', $comment);
        $comment->delete();

        return back()->with('success', __('Comment has been deleted.'));
    }
}
