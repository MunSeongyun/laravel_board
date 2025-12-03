<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;

class AdminCommentController extends Controller
{
    public function restore(Comment $adminComment)
    {
        Gate::authorize('restore', Comment::class);
        $adminComment->restore();
        return back()->with('success', __('Comment has been restored.'));
    }

    public function forceDelete(Comment $adminComment)
    {
        Gate::authorize('forceDelete', Comment::class);
        $adminComment->forceDelete();
        return back()->with('success', __('Comment has been permanently deleted.'));
    }
}
