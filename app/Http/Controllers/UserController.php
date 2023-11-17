<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class UserController extends Controller
{
    public function updateName(Request $request)
    {
        $this->authorize('edit', User::class);
        // Get the authenticated user
        $user = Auth::user();

        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:appuser', 
        ]);

        $user->name = $request->input('name');
        
        return redirect()->route('profile');
    }
}
