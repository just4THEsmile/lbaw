<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;


use App\Models\User;

class UserController extends Controller
{

    public function updateUser(Request $request){
        $userId = $request->input('user_id');
        $userAuth = Auth::user();
        $user = User::find($userId);
        $this->authorize('edit', $user);

        try {
            $request->validate(['name' => 'required|string|max:255']);
            $user->name = $request->input('name');
        } catch (ValidationException $e) {
            
        }
    
        try {
            $request->validate(['username' => 'required|string|max:255|unique:appuser']);
            $user->username = $request->input('username');
        } catch (ValidationException $e) {}
    
        try {
            $request->validate(['email' => 'required|email|max:255|unique:appuser']);
            $user->email = $request->input('email');
        } catch (ValidationException $e) {}
    
        try {
            $request->validate(['password' => 'required|string|min:8']);
            $user->password = Hash::make($request->input('password'));
        } catch (ValidationException $e) {}
    
        try {
            $request->validate(['bio' => 'required|string']);
            $user->bio = $request->input('bio');
        } catch (ValidationException $e) {}
    
        try {
            $request->validate(['paylink' => 'required|url']);
            $user->paylink = $request->input('paylink');
        } catch (ValidationException $e) {}
    
        $user->save();

        return redirect()->route('editprofile', ['id' => $user->id]);


    }

    public function updateProfilePicture(Request $request)
    {
        $userId = $request->input('user_id');
        $userAuth = Auth::user();

        $user = User::find($userId);
        $this->authorize('edit', $user);
    
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

    public function deleteAccount(Request $request,string $id)
    {
        $userBeingDeleted = User::find($id);

        $this->authorize('delete', $userBeingDeleted);
        TransactionsController::deleteUser($userBeingDeleted->id);
        return redirect()->route('logout');
    }
}
