<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Content;
use Illuminate\Support\Facades\Auth;

class ContentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function report(): bool
    {
        return Auth::check();
    }
    
}