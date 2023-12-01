<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Question;
use App\Models\Content;
use Illuminate\Support\Facades\DB;
class ProfileController extends Controller
{
    /**
     * Display the home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($id)
    {    if(Auth::check()){
            $user = User::find($id);
            return view('pages.profile', ['user' => $user]);
        }else{
            return redirect('/login');
        }
    }
    public function edit($id){
        $user = User::find($id);
        if(Auth::user()->id !== $user->id && Auth::user()->usertype !== 'admin'){
            return view('pages.profile', ['user' => $user]);
        }
        return view('pages.userprofile', ['user' => $user]);
    }
    public function myquestions($id){
        return view('pages.myquestions', ['user_id' => $id]);
    }
    public function listmyquestions(Request $request,$id){
        $user = User::find($id); 
        if($user == null){
            return response()->json([
                'message' => 'User not found',
            ], 302);
        }
        $orderBy= $request->input('OrderBy');
        $questions = Content::select('question.title as title', 'content.content as content', 'content.votes as votes', 'question.id as id', 'content.date as date')
        ->where('user_id', $id)
        ->join('question','question.id','=','content.id')
        ->orderBy($orderBy, 'desc')
        ->paginate(10)
        ->withqueryString(); 
        foreach($questions as $result){
            $result->date = $result->compileddate();
        }
        return response()->json($questions) ;
    }
    public function myanswers($id){
        $user = User::find($id);
        return view('pages/myanswers', ['user' => $user]);
    }
    public function listmyanswers(Request $request,$id){
        $orderBy = $request->input('OrderBy');
        if(Auth::check()){
            $answers = Content::where('user_id', $id)
            ->join('answer','content.id','=','answer.id')
            ->orderBy($orderBy, 'desc')
            ->paginate(15)->withqueryString(); 
            foreach($answers as $result){
                $result->date = $result->compileddate();
            }
            return response()->json($answers) ;
        }else{
        return response()->json([
            'message' => 'Not logged in',
        ], 302);
    }
    }
    public function followedQuestions($id)
    {   if(Auth::check()){

        $user = User::find($id); 
        return view('pages.followquestion',  ['user' => $user]);
        }else{
            return redirect('/login');
        }
    }
    public function listfollowedquestions(Request $request,$id){
        $orderBy = $request->input('OrderBy');
        $followedQuestions = Content::select('content.content as content', 'question.title as title', 'content.votes as votes', 'question.id as id', 'content.date as date')
        ->join('question', 'content.id', '=', 'question.id')
        ->join('followquestion', 'followquestion.question_id', '=', 'question.id')
        ->where('followquestion.user_id', $id)
        ->orderBy($orderBy, 'desc')
        ->paginate(15)->withqueryString();
        foreach($followedQuestions as $result){
            $result->date = $result->compileddate();
        }
        return response()->json($followedQuestions) ;
    }
}
