<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function updateName(Request $request) {
        // Retrieve the new name from the form input
        $newName = $request->input('name');

        // Update the user's name
        $user = Auth::user();
        $user->name = $newName;
        $user->save();

        // Redirect back or to a specific route after updating
        return redirect()->back()->with('success', 'Name updated successfully');
    }
}
