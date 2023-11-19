<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Question;
use App\Models\Content;
use Illuminate\Support\Facades\Auth;

class QuestionPolicy
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
    public function show(User $user): bool
    {
        return Auth::check();
    }
    /**
     * Determine if a given Question can be shown to a user.
     */
    public function createform(User $user): bool
    {
        return Auth::check();
    }
    /**
     * Determine if a given Question can be shown to a user.
     */
    public function editform(User $user,Question $question): bool
    {
        $content= Content::find($question->id);
      // Only a Question owner can delete it.
      return $user->id === $content->user_id || $user->usertype === "admin" || $user->usertype === "moderator";
    }
    /**
     * Determine if all Questions can be listed by a user.
     */
    public function list(User $user): bool
    {
        // Any (authenticated) user can list its own Questions.
        return Auth::check();
    }

    /**
     * Determine if a Question can be created by a user.
     */
    public function create(User $user): bool
    {
        // Any user can create a new Question.
        return Auth::check();
    }

    /**
     * Determine if a question can be deleted by a user.
     */
    public function edit(User $user, Question $question): bool
    {
        $content= Content::find($question->id);
      // Only a Question owner can delete it.
      return $user->id === $content->user_id || $user->usertype === "admin" || $user->usertype === "moderator";
    }

    /**
     * Determine if a question can be deleted by a user.
     */
    public function delete(User $user, Question $question): bool
    {
        $content= Content::find($question->id);
      // Only a Question owner can delete it.
      return $user->id === $content->user_id || $user->usertype === "admin" || $user->usertype === "moderator";
    }
}