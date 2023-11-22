<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


use App\Models\User;

class UserController extends Controller
{
    public function updateName(Request $request)
    {
        
        $userId = $request->input('user_id');
        $userAuth = Auth::user();

        $this->authorize('edit', $userId);

        $user = User::find($userId);

        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255', 
        ]);

        $user->name = $request->input('name');
        $user->save();

        return redirect()->route('editprofile', ['id' => $user->id]);
    }

    public function updateUsername(Request $request)
    {
            
        $userId = $request->input('user_id');
        $userAuth = Auth::user();

        $this->authorize('edit', $userId);

        $user = User::find($userId); 
    
        // Validate the incoming request data
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:appuser', 
        ]);
    
        $user->username = $request->input('username');
            
        $user->save();
    
        return redirect()->route('editprofile', ['id' => $user->id]);
    }

    public function updateEmail(Request $request)
    {
                
        $userId = $request->input('user_id');
        $userAuth = Auth::user();

        $this->authorize('edit', $userId);

        $user = User::find($userId); 
        // Validate the incoming request data
        $validatedData = $request->validate([
            'email' => 'required|email|max:255|unique:appuser', 
        ]);
        
        $user->email = $request->input('email');
                
        $user->save();
        
        return redirect()->route('editprofile', ['id' => $user->id]);
    }

    public function updatePassword(Request $request)
    {
                        
        $userId = $request->input('user_id');
        $userAuth = Auth::user();

        $this->authorize('edit', $userId);

        $user = User::find($userId); 
                
        // Validate the incoming request data
        $validatedData = $request->validate([
            'password' => 'required|string|min:8', 
        ]);
                
        $user->password = Hash::make($validatedData['password']);
           
        $user->save();
                
        return redirect()->route('editprofile', ['id' => $user->id]);
    }

    public function updateBio(Request $request)
    {
                                
        $userId = $request->input('user_id');
        $userAuth = Auth::user();

        $this->authorize('edit', $userId);

        $user = User::find($userId); 
            
        // Validate the incoming request data
        $validatedData = $request->validate([
            'bio' => 'required|string', 
        ]);
                        
        $user->bio = $request->input('bio');
                   
        $user->save();
                        
        return redirect()->route('editprofile', ['id' => $user->id]);
    }

    public function updateProfilePicture(Request $request)
    {
        $userId = $request->input('user_id');
        $userAuth = Auth::user();

        $this->authorize('edit', $userId);

        $user = User::find($userId); 
    
        if ($request->hasFile('profilepicture')) {

            if ($user->profilepicture) {
                if($user->profilepicture != 'images/xSHEr42ExnTkF65eLIJtvlwAumV6O6B4t0ZeeJ5e.png')
                Storage::disk('public')->delete($user->profilepicture);
            }

            $profilePicture = $request->file('profilepicture');
            $path = $profilePicture->store('images', 'public');

            $user->profilepicture = $path;
            $user->save();

            return redirect()->route('editprofile', ['id' => $user->id]);
        }
    }

    public function updatePayLink(Request $request)
    {
        $userId = $request->input('user_id');
        $userAuth = Auth::user();

        $this->authorize('edit', $userId);

        $user = User::find($userId); 
        // Validate the incoming request data
        $validatedData = $request->validate([
            'paylink' => 'required|url', 
        ]);
    
        $user->paylink = $request->input('paylink');
            
        $user->save();
    
        return redirect()->route('editprofile', ['id' => $user->id]);
    }
    public function deleteMyUser(Request $request)
    {
        $userId = $request->input('user_id');
        $userAuth = Auth::user();

        $this->authorize('delete', $userAuth);
        TransactionsController::deleteUser($user_Id);
        return redirect()->route('logout');
    }
}
