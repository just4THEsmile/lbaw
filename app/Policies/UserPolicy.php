<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    
    public function edit(User $userAuth,User $user) 
    {

      return $userAuth->id === $user->id || $userAuth->usertype === "admin" || $userAuth->usertype === "moderator";
    }   
    public function delete(User $userAuth,User $user) 
    {

      return $userAuth->id === $user->id || $userAuth->usertype === "admin" || $userAuth->usertype === "moderator";
    }
    public function editadmin(User $userAuth,User $user) 
    {

      return $userAuth->usertype === "admin";
    }
}