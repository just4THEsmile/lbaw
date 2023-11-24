<?php

namespace App\Policies;


use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ContentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function report(User $user): bool
    {
        return Auth::check();
    }
    
}