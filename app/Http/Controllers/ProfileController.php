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
        if(Auth::user() == null){
            return redirect('/login');
        }
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
            return view('pages.myquestions', ['user' => $user]);
        }else{
            return redirect('/login');
        }
    }
    public function myanswers($id){
        if(Auth::check()){
            $user = User::find($id);
            return view('pages.myanswers', ['user' => $user]);
        }
        return redirect('/login');
    }
    
    public function myblocked($id)
    {
        if(Auth::user()== null){
            return redirect('/login');
        }
        $user = User::find($id);
    
        $blockedContent = Content::where('user_id', $id)
            ->where('blocked', true)
            ->with(['comment', 'question', 'answer'])
            ->paginate(5);
    
        foreach ($blockedContent as $result) {
            if ($result->comment) {
                $result->type = 'comment';
                $result->content_id = $result->comment->id;
            } elseif ($result->answer) {
                $result->type = 'answer';
                $result->content_id = $result->answer->id;
            } elseif ($result->question) {
                $result->type = 'question';
                $result->content_id = $result->question->id;
            }
        }
        foreach($blockedContent as $result){
            $result->date = $result->compileddate();
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
        $questions = Question::select(
            'question.title', 
            'content.content', 
            'appuser.username', 
            'content.date', 
            'content.id as id', 
            'appuser.id as userid', 
            'content.votes as votes',
            'tags_agg.title as tags',
            'tags_agg.id as tagsid',
            DB::raw('COUNT(answer.id) as answernum')
        )
        ->join('content', 'question.id', '=', 'content.id')
        ->join('appuser', 'content.user_id', '=', 'appuser.id')
        ->leftjoin('answer', 'answer.question_id', '=', 'question.id')
        ->leftjoin(
            DB::raw('(SELECT question.id as qid, STRING_AGG(tag.title, \',\' ORDER BY tag.id ASC) as title, STRING_AGG(CAST(tag.id AS TEXT), \',\' ORDER BY tag.id ASC) as id FROM questiontag JOIN tag ON tag.id = questiontag.tag_id JOIN question ON question.id = questiontag.question_id GROUP BY question.id) as tags_agg'),
            'tags_agg.qid',
            '=',
            'question.id'
        )
        ->where('content.deleted', '=', false)
        ->where('content.user_id', '=', $id)
        ->groupBy(
            'question.title',
            'content.content',
            'appuser.username',
            'content.date',
            'content.id',
            'appuser.id',
            'content.votes',
            'tags_agg.title',
            'tags_agg.id'
        )
        ->orderBy($orderBy, 'desc')
        ->paginate(15)
        ->withqueryString(); 
        foreach($questions as $result){
            $result->date = $result->commentable->content->compileddate();
        }
        return response()->json($questions);
    }
    public function listmyanswers(Request $request,$id){
        $orderBy = $request->input('OrderBy');
        if(Auth::check()){
            $answers = Content::select('question.id as question_id','content.content as content','content.votes as votes', 'content.reports as reports','question.title as tile','content.blocked as blocked', 'question.correct_answer_id as correct_answer_id','content.date as date', 'content.deleted as deleted','content.edited as edited','content.id as id', 'appuser.username as username', 'appuser.id as userid')
            ->join('answer','content.id','=','answer.id')
            ->join('question','question.id','=','answer.question_id')
            ->join('appuser','appuser.id','=','content.user_id')
            ->where('content.deleted', '=', false)
            ->where('user_id', $id)
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
        if(! Auth::check()){
            return response()->json([
                'message' => 'Not logged in',
            ], 302);
        }
        $orderBy = $request->input('OrderBy');
        $followedQuestions = Question::select(
            'question.title', 
            'content.content', 
            'appuser.username', 
            'content.date', 
            'content.id as id', 
            'appuser.id as userid', 
            'content.votes as votes',
            'tags_agg.title as tags',
            'tags_agg.id as tagsid',
            DB::raw('COUNT(answer.id) as answernum')
        )
        ->join('content', 'question.id', '=', 'content.id')
        ->join('appuser', 'content.user_id', '=', 'appuser.id')
        ->leftjoin('answer', 'answer.question_id', '=', 'question.id')
        ->leftjoin(
            DB::raw('(SELECT question.id as qid, STRING_AGG(tag.title, \',\' ORDER BY tag.id ASC) as title, STRING_AGG(CAST(tag.id AS TEXT), \',\' ORDER BY tag.id ASC) as id FROM questiontag JOIN tag ON tag.id = questiontag.tag_id JOIN question ON question.id = questiontag.question_id GROUP BY question.id) as tags_agg'),
            'tags_agg.qid',
            '=',
            'question.id'
        )
        ->where('content.deleted', '=', false)
        ->where('content.user_id', '=', $id)
        ->groupBy(
            'question.title',
            'content.content',
            'appuser.username',
            'content.date',
            'content.id',
            'appuser.id',
            'content.votes',
            'tags_agg.title',
            'tags_agg.id'
        )
        ->orderBy($orderBy, 'desc')
        ->paginate(15)->withqueryString();
        foreach($followedQuestions as $result){
            $result->date = $result->commentable->content->compileddate();
        }
        return response()->json($followedQuestions);
    }

    public function listmyblocked($id){
        if(! Auth::check()){
            return response()->json([
                'message' => 'Not logged in',
            ], 302);
        }
        $blockedContent = Content::where('user_id', $id)->where('blocked', true)->get();
        foreach($blockedContent as $result){
            $result->date = $result->compileddate();
        }
        return response()->json($blockedContent) ;
    }
}
