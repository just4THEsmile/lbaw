<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Question;
use App\Models\Content;
use Illuminate\Support\Facades\Auth;

class CardPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if a given card can be shown to a user.
     */
    public function show(User $user): bool
    {
        return Auth::check();
    }

    /**
     * Determine if all cards can be listed by a user.
     */
    public function list(User $user): bool
    {
        // Any (authenticated) user can list its own cards.
        return Auth::check();
    }

    /**
     * Determine if a card can be created by a user.
     */
    public function create(User $user): bool
    {
        // Any user can create a new card.
        return Auth::check();
    }

    /**
     * Determine if a question can be deleted by a user.
     */
    public function edit(User $user, Question $question): bool
    {
        $content= Content::find($question->id);
      // Only a card owner can delete it.
      return $user->id === $content->user_id || $user->usertype === "admin" || $user->usertype === "moderator";
    }

    /**
     * Determine if a question can be deleted by a user.
     */
    public function delete(User $user, Question $question): bool
    {
        $content= Content::find($question->id);
      // Only a card owner can delete it.
      return $user->id === $content->user_id || $user->usertype === "admin" || $user->usertype === "moderator";
    }
}