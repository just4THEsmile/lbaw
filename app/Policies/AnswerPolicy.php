<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Answer;
use App\Models\Content;
use Illuminate\Support\Facades\Auth;

class AnswerPolicy
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
    public function editform(User $user,Answer $answer): bool
    {
        $content= Content::find($answer->id);
      // Only a Question owner can delete it.
      return $user->id === $content->user_id || $user->usertype === "admin" || $user->usertype === "moderator";
    }

    /**
     * Determine if a Answer can be created by a user.
     */
    public function create(User $user): bool
    {
        // Any user can create a new Answer.
        return Auth::check();
    }

    /**
     * Determine if a Answer can be deleted by a user.
     */
    public function edit(User $user, Answer $answer): bool
    {
        $content= Content::find($answer->id);
      // Only a Answer owner can delete it.
      return $user->id === $content->user_id || $user->usertype === "admin" || $user->usertype === "moderator";
    }

    /**
     * Determine if a Answer can be deleted by a user.
     */
    public function delete(User $user, Answer $answer): bool
    {
        $content= Content::find($answer->id);
      // Only a Answer owner can delete it.
      return $user->id === $content->user_id || $user->usertype === "admin" || $user->usertype === "moderator";
    }
}