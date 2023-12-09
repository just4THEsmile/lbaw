<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TagPolicy
{
    
    public function edit(User $userAuth) 
    {

      return $userAuth->usertype === "admin";
    }   
    public function delete(User $userAuth) 
    {

      return $userAuth->usertype === "admin";
    }
    public function create(User $userAuth) 
    {
      return $userAuth->usertype === "admin";
    }
}