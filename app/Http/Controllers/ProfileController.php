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
    public function index()
    {
        return view('pages/profile');
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
}
