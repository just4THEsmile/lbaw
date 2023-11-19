<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    
    public function edit() 
    {
      return Auth::check();
    }   
    
}