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
        
        $user = Auth::user();
        $this->authorize('edit', $user);  

        
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255', 
        ]);

        $user->name = $request->input('name');
        
        $user->save();

        return view('pages.userprofile', [
            'user' => $user
        ]);
    }

    public function updateUsername(Request $request)
    {
            
        $user = Auth::user();
        $this->authorize('edit', $user);  
    
        // Validate the incoming request data
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:appuser', 
        ]);
    
        $user->username = $request->input('username');
            
        $user->save();
    
        return view('pages.userprofile', [
            'user' => $user
        ]);
    }

    public function updateEmail(Request $request)
    {
                
        $user = Auth::user();
        $this->authorize('edit', $user);  

        // Validate the incoming request data
        $validatedData = $request->validate([
            'email' => 'required|email|max:255|unique:appuser', 
        ]);
        
        $user->email = $request->input('email');
                
        $user->save();
        
        return view('pages.userprofile', [
            'user' => $user
        ]);
    }

    public function updatePassword(Request $request)
    {
                        
        $user = Auth::user();
        $this->authorize('edit', $user);  
                
        // Validate the incoming request data
        $validatedData = $request->validate([
            'password' => 'required|string|min:8', 
        ]);
                
        $user->password = Hash::make($validatedData['password']);
           
        $user->save();
                
        return view('pages.userprofile', [
            'user' => $user
        ]);
    }

    public function updateBio(Request $request)
    {
                                
        $user = Auth::user();
        $this->authorize('edit', $user);  
                        
        // Validate the incoming request data
        $validatedData = $request->validate([
            'bio' => 'required|string', 
        ]);
                        
        $user->bio = $request->input('bio');
                   
        $user->save();
                        
        return view('pages.userprofile', [
            'user' => $user
        ]);
    }

    public function updateProfilePicture(Request $request)
    {
        $user = Auth::user();
        $this->authorize('edit', $user);  
    
        if ($request->hasFile('profilepicture')) {

            $profilePicture = $request->file('profilepicture');
            $path = $profilePicture->store('images', 'public');

            $user->profilepicture = $path;
            $user->save();

            return view('pages.userprofile', [
                'user' => $user
            ]);
        }
    }

    public function updatePayLink(Request $request)
    {
        $user = Auth::user();
        $this->authorize('edit', $user);  
    
        // Validate the incoming request data
        $validatedData = $request->validate([
            'paylink' => 'required|url', 
        ]);
    
        $user->paylink = $request->input('paylink');
            
        $user->save();
    
        return view('pages.userprofile', [
            'user' => $user
        ]);
    }
}
