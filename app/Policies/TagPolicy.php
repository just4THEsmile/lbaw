<?php

namespace App\Policies;

use App\Models\Tag;

use Illuminate\Support\Facades\Auth;

class TagPolicy
{
    
    public function edit(User $userAuth,Tag $tag) 
    {

      return $userAuth->usertype === "admin";
    }   
    public function delete(User $userAuth,Tag $user) 
    {

      return $userAuth->usertype === "admin";
    }
    public function create(User $userAuth,Tag $user) 
    {
      return $userAuth->usertype === "admin";
    }
}