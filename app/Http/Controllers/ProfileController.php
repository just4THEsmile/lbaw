<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display the home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($id)
    {    
        return view('pages.profile', ['userId' => $id]);
    }
    public function edit(){
        return view('pages/userprofile');
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
    public function users(){
        return view('pages/users');
    }
}
