<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * 목록에 접근 할 수 있는지 여부
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * 특정 post에 접근 할 수 있는지 여부
     */
    public function view(User $user, Post $post): bool
    {
        return true;
    }

    /**
     * post를 저장할 수 있는지 여부
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * post를 수정할 수 있는지 여부
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id || $user->is_admin();
    }

    /**
     * post를 삭제할 수 있는지 여부
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id || $user->is_admin() ;
    }

    /**
     * 삭제된 post를 복원할 수 있는지 여부
     */
    public function restore(User $user): bool
    {
        return $user->is_admin();
    }

    /**
     * post를 영구 삭제할 수 있는지 여부
     */
    public function forceDelete(User $user): bool
    {
        return $user->is_admin();
    }
}
