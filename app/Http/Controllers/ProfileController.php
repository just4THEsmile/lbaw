<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
        return view('pages/userprofile', ['user' => $user]);
    }
    public function myquestions(){
        return view('pages/myquestions');
    }
    public function myanswers(){
        return view('pages/myanswers');
    }
    public function followquestion(){
        return view('pages/followquestion');
    }
}
