<?php

namespace App\Policies;


use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Content;
class ContentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function report(User $user,Content $content): bool
    {
        return Auth::check() && $user->id !== $content->user_id;
    }
    
}