<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
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
        if(Auth::user()->id !== $user->id && Auth::user()->usertype !== 'admin'){
            return view('pages.profile', ['user' => $user]);
        }
        return view('pages/userprofile', ['user' => $user]);
    }



    public function edit2($id){
        $user = User::find($id);
        if(Auth::user()->id !== $user->id && Auth::user()->usertype !== 'admin'){
            return view('pages.profile', ['user' => $user]);
        }
        return view('pages/userprofile2', ['user' => $user]);
    }

    

    public function myquestions($id){
        return view('pages/myquestions', ['user_id' => $id]);
    }
    public function listmyquestions($id){
        $user = User::find($id); 
        $questions = $user->questions();
        foreach($questions as $result){
            $result->date = $result->commentable->content->compileddate();
        }
        return response()->json($questions) ;
    }
    public function myanswers($id){
        $user = User::find($id);
        return view('pages/myanswers', ['user' => $user]);
    }
    public function listmyanswers($id){
        $user = User::find($id); 
        $answers = $user->answers();
        foreach($answers as $result){
            $result->date = $result->commentable->content->compileddate();
        }
        return response()->json($answers) ;
    }
    public function followedQuestions($id)
    {   
        $user = User::find($id); 
        return view('pages/followquestion',  ['user' => $user]);
    }
    public function listfollowedquestions($id){
        $followedQuestions = Question::select('content.content as content', 'question.title as title', 'content.votes as votes', 'question.id as id', 'content.date as date')
        ->join('followquestion', 'followquestion.question_id', '=', 'question.id')
        ->join('commentable', 'commentable.id', '=', 'question.id')
        ->join('content','content.id','=','commentable.id')
        ->where('followquestion.user_id', $id)
        ->get();
        foreach($followedQuestions as $result){
            $result->date = $result->commentable->content->compileddate();
        }
        return response()->json($followedQuestions) ;
    }
}
