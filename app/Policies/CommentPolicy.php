<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use App\Models\Content;
use Illuminate\Support\Facades\Auth;

class CommentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    /**
     * Determine if a given Question can be shown to a user.
     */
    public function editform(User $user,Comment $comment): bool
    {
        $content= Content::find($comment->id);
      // Only a Question owner can delete it.
      return $user->id === $content->user_id || $user->usertype === "admin" || $user->usertype === "moderator";
    }

    /**
     * Determine if a Comment can be created by a user.
     */
    public function create(User $user): bool
    {
        // Any user can create a new Comment.
        return Auth::check();
    }

    /**
     * Determine if a Comment can be deleted by a user.
     */
    public function edit(User $user, Comment $comment): bool
    {
        $content= Content::find($comment->id);
      // Only a Comment owner can delete it.
      return $user->id === $content->user_id || $user->usertype === "admin" || $user->usertype === "moderator";
    }

    /**
     * Determine if a Comment can be deleted by a user.
     */
    public function delete(User $user, Comment $comment): bool
    {
        $content= Content::find($comment->id);
      // Only a Comment owner can delete it.
      return $user->id === $content->user_id || $user->usertype === "admin" || $user->usertype === "moderator";
    }
}