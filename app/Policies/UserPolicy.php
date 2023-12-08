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
    public function block(User $userAuth,User $user) 
    {
      return $userAuth->usertype === "admin";
    }
    public function unblockform(User $userAuth,User $user) 
    {
      return Auth::check() && $user->id === Auth::user()->id && $user->blocked;
    }
    public function review(User $userAuth,User $user) 
    {
      return $userAuth->usertype === "admin" || $userAuth->usertype === "moderator";
    }
    public function process(User $userAuth,User $user) 
    {
      return $userAuth->usertype === "admin" || $userAuth->usertype === "moderator";
    }
}