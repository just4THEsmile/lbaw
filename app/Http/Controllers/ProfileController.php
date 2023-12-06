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



    public function edit2($id){
        $user = User::find($id);
        if(Auth::user()->id !== $user->id && Auth::user()->usertype !== 'admin'){
            return view('pages.profile', ['user' => $user]);
        }
        return view('pages/userprofile2', ['user' => $user]);
    }

    

    public function myquestions($id){
        if(Auth::check()){
            $user = User::find($id);
            return view('pages.myquestions', ['user_id' => $id]);
        }else{
            return redirect('/login');
        }
    }
    public function myanswers($id){
        $user = User::find($id);
        return view('pages/myanswers', ['user' => $user]);
    }
    
    public function myblocked($id){
        $user = User::find($id);
        $blockedContent = Content::where('user_id', $id)->where('blocked', true)
            ->leftJoin('question', 'content.id', '=', 'question.id')
            ->leftJoin('answer', 'content.id', '=', 'answer.id')
            ->leftJoin('comment', 'content.id', '=', 'comment.id')
            ->paginate(5);
        foreach($blockedContent as $result){
            if($result->commentable_id != null){
                $result->type = 'comment';
            }else if($result->answer_id != null){
                $result->type = 'answer';
            }else{
                $result->type = 'question';
            }

        }
        
        return view('pages/myblocked', ['user' => $user, 'blockedContent' => $blockedContent]);
    }

    public function listmyquestions(Request $request ,$id){
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
    public function listfollowedquestions(Request $request , $id){
        $orderBy = $request->input('OrderBy');
        $followedQuestions = Question::select('content.content as content', 'question.title as title', 'content.votes as votes', 'question.id as id', 'content.date as date')
        ->join('followquestion', 'followquestion.question_id', '=', 'question.id')
        ->where('followquestion.user_id', $id)
        ->orderBy($orderBy, 'desc')
        ->paginate(15)->withqueryString();
        foreach($followedQuestions as $result){
            $result->date = $result->compileddate();
        }
        return response()->json($followedQuestions) ;
    }

    public function listmyblocked($id){
        $blockedContent = Content::where('user_id', $id)->where('blocked', true)->get();
        foreach($blockedContent as $result){
            $result->date = $result->compileddate();
        }
        return response()->json($blockedContent) ;
    }
}
