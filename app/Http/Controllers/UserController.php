<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;


use App\Models\User;
use App\Models\FollowQuestion;
use App\Models\Notification;
use App\Models\BadgeAttainmentNotification;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{

    public function updateUser(Request $request){
        $userId = $request->input('user_id');
        $userAuth = Auth::user();
        $this->authorize('edit', $userAuth);
        $user = User::find($userId);

            $request->validate(['name' => 'required|string|max:16',
            'paylink' => 'url'
        ]);

        if($user->username !== $request->input('username')){
            $request->validate(['username' => 'required|string|max:16|unique:appuser']);
            
        }
        $user->name = $request->input('name');
        if($user->email !== $request->input('email') ){
            $request->validate(['email' => 'required|email|max:40|unique:appuser']);
            $user->email = $request->input('email');
        }

        $new_password = $request->input('password');
        if( strlen($new_password )!== 0){
            $request->validate(['password' => 'required|string|min:8']);
            $user->password = Hash::make($request->input('password'));
        }
        $user->bio = $request->input('bio');

        $user->paylink = $request->input('paylink');

        $user->save();

        return redirect()->route('editprofile', ['id' => $user->id]);


    }

    public function updateUserAdmin(Request $request){

        $userId = $request->input('user_id');
        $userAuth = Auth::user();
        $this->authorize('editadmin', $userAuth);

        $user = User::find($userId);
        
        $user->usertype = $request->input('usertype');
        
        $badges = $request->input('badges');
        $userBadges = $user->badges()->get();
        if($badges){
            $badgeData = [];
            $date = date('Y-m-d H:i:s'); 
            foreach($badges as $badge) {
                $badgeData[$badge] = ['date' => $date];
            }
            $user->badges()->sync($badgeData);
            foreach($userBadges as $t){
                if( $t->id !== $badge){
                    $notification = Notification::create([
                        'user_id' => $user->id,
                        'date' => $date
                    ]);
                    $notification->save();
                    DB::table('badgeattainmentnotification')->insert(
                        ['user_id' => $user->id,'badge_id' => $badge,'notification_id' => $notification->id]
                    );
                    break;
                }
            }
        }
    
        $user->save();

        return redirect()->route('editprofile', ['id' => $user->id]);
    }


    public function deleteAccount(Request $request,string $id)
    {
        $userBeingDeleted = User::find($id);

        $this->authorize('delete', $userBeingDeleted);
        TransactionsController::deleteUser($userBeingDeleted->id);
        return redirect()->route('logout');
    }
       
}
