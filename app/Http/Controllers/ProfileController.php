<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display the home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($id)
    {    
        $user = User::find($id);
        return view('pages/profile', ['user' => $user]);
    }
    public function edit($id){
        $user = User::find($id);
        $auth = Auth::user();
        if(Auth::user()->id !== $user->id && Auth::user()->usertype !== 'admin'){
            return view('pages.profile', ['user' => $user]);
        }
        return view('pages/userprofile', ['user' => $user]);
    }
    public function myquestions($id){
        $user = User::find($id);
        return view('pages/myquestions', ['user' => $user]);
    }
    public function myanswers($id){
        $user = User::find($id);
        return view('pages/myanswers', ['user' => $user]);
    }

}
