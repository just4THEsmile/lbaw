<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    
    public function edit(User $user,string $userid) 
    {
      return $user->id === $user_id || $user->usertype === "admin" || $user->usertype === "moderator";
    }   
    public function delete(User $user,string $userid): bool
    {
      return $user->id === $user_id || $user->usertype === "admin" || $user->usertype === "moderator";
    }
    
}