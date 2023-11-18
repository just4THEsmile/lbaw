<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserController extends Controller
{
    public function updateName(Request $request)
    {
        
        // Get the authenticated user
        $user = Auth::user();

        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255', 
        ]);

        $user->name = $request->input('name');
        
        $user->save();

        return redirect()->route('profile');
    }

    public function updateUsername(Request $request)
    {
            
        // Get the authenticated user
        $user = Auth::user();
    
        // Validate the incoming request data
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:appuser', 
        ]);
    
        $user->username = $request->input('username');
            
        $user->save();
    
        return redirect()->route('profile');
    }

    public function updateEmail(Request $request)
    {
                
        // Get the authenticated user
        $user = Auth::user();
        
        // Validate the incoming request data
        $validatedData = $request->validate([
            'email' => 'required|email|max:255|unique:appuser', 
        ]);
        
        $user->email = $request->input('email');
                
        $user->save();
        
        return redirect()->route('profile');
    }

    public function updatePassword(Request $request)
    {
                        
        // Get the authenticated user
        $user = Auth::user();
                
        // Validate the incoming request data
        $validatedData = $request->validate([
            'password' => 'required|string|min:8', 
        ]);
                
        $user->password = Hash::make($validatedData['password']);
           
        $user->save();
                
        return redirect()->route('profile');
    }

    public function updateBio(Request $request)
    {
                                
        // Get the authenticated user
        $user = Auth::user();
                        
        // Validate the incoming request data
        $validatedData = $request->validate([
            'bio' => 'required|string', 
        ]);
                        
        $user->bio = $request->input('bio');
                   
        $user->save();
                        
        return redirect()->route('profile');
    }

    public function updateProfilePicture(Request $request)
    {
        $user = Auth::user();
    
        if ($request->hasFile('profilepicture')) {

            $profilePicture = $request->file('profilepicture');
            $path = $profilePicture->store('images', 'public');

            $user->profilepicture = $path;
            $user->save();

            return redirect()->route('profile');
        }
    }


}
