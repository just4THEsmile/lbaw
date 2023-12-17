<?php

namespace App\Http\Controllers;
use App\Http\Controllers\TransactionsController;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Question;
use App\Models\Content;
use App\Models\Commentable;
use App\Models\FollowQuestion;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Models\Answer;
class QuestionController extends Controller
{
    public function show(string $id)
    {
        // Get the question.
        $question = Question::find($id);
        // Check if the current user can see (show) the question.
        if($question === null){
            return redirect('/home')->withErrors(['page' => 'The provided question was not found.']);
        }
        $this->authorize('show', $question);  

        $question->date = $question->commentable->content->compileddate();
        $answers = Answer::join('content','content.id','=','answer.id')->orderBy('content.votes','desc')->where('question_id' , $id)->paginate(15);
        // Use the pages.question template to display the question.
        return view('pages.question', [
            'question' => $question , 'answers' => $answers
        ]);
    }
    /**
     * Creates a new question.
     */
    public function createform(){
        if (Auth::check()) {
            return view('pages.questioncreate');
        } else {
            return redirect('/login');
        }
        
    }
    public function create(Request $request)
    {
        $question = new Question();
        
        // Check if the current user is authorized to delete this question.
        $this->authorize('create', $question);
        $tags = $request->input('tags');
        if(sizeof(explode(",", $tags)) > 5){
            return response()->json([
                'messages' => ['tags' => 'Too many tags only 5 tags are allowed'],
            ],400);
        }
        $validator=Validator::make($request->all(),['title' => 'required|string|min:4|max:70','content' => 'required|string|min:16|max:255']);
        if ($validator->fails()) {
            return response()->json(['messages'=>$validator->getMessageBag()], 400);
        }
        $title = $request->input('title');
        $content = $request->input('content');
        //dd($request->input('tags'));
        $question = TransactionsController::createQuestion(Auth::user()->id,$title,$content,$tags);
        if($question === false){
            return response()->json([
                'messages' => ['message' => "something went wrong when creating the question"],
            ], 500);
        }
        return response()->json($question->id);

    }

    /**
     * Delete a question.
     */
    public function delete(Request $request, $id)
    {
        // Find the question.
        $question = Question::find($id);

        // Check if the current user is authorized to delete this question.
        $this->authorize('delete', $question);
        // Delete the question and return it as JSON.
        $result = TransactionsController::deleteQuestion($question->id);
        if($result === null){
            return redirect('/home/1');
        }
        return redirect('/home');
    }

    public function editform(string $id){
        $question = Question::find($id);
        if($question === null || $question->commentable->content->deleted === true){
            return redirect('/home');
        }
        if (Auth::check()) {
            if(Auth::user()->id === $question->commentable->content->user_id || Auth::user()->usertype === 'admin' || Auth::user()->usertype === 'moderator'){
                return view('pages.questionedit', ['question' => $question]);
            }
            return redirect('/home');
        } else {
            return redirect('/login');
        }
    }
    public function edit(Request $request, $id)
    {
        // Find the question.
        $question = Question::find($id);
        if($question === null || $question->commentable->content->deleted === true){
            return redirect('/home');
        }
        // Check if the current user is authorized to delete this question.
        $this->authorize('edit', $question);
        if(sizeof(explode(",", $request->input('tags'))) > 5){
            return response()->json([
                'messages' =>['tags' => 'Too many tags'],
            ],400);
        }
        $validator=Validator::make($request->all(),['title' => 'required|string|min:4|max:70','content' => 'required|string|min:16|max:255']);
        if ($validator->fails()) {
            return response()->json(['messages'=>$validator->getMessageBag()], 400);
        }
        //dd($request->input('tags'));
        $result = TransactionsController::editQuestion($question->id,$request->input('title'),$request->input('content'),$request->input('tags'));
        if($result === false){
            return response()->json([
               'messages' => ['message' => "something went wrong when creating the question"],
            ], 500);
        }
        return response()->json($result);
    }

    public function follow(Request $request, $id){
        if(!Auth::check()){
            return redirect('/login');
        }
        if(Auth::user()->blocked === true){
            return redirect('/home');
        }
        $question = Question::find($id);
        if($question === null || $question->commentable->content->deleted === true){
            return redirect('/home');
        }
        $this->authorize('follow', $question);
        

        if (FollowQuestion::where('user_id', Auth::user()->id)->where('question_id', $question->commentable->content->id)->exists()) {
            
            FollowQuestion::where('user_id', Auth::user()->id)->where('question_id', $question->commentable->content->id)->delete();
        }
        else{
            $follow = new FollowQuestion([
                'user_id' => Auth::user()->id,
                'question_id' => $question->id,
            ]);
            
            $follow->save();
        }
        

        return redirect('/question/' . $question->id);
    }

    public function correctanswer(Request $request, $questionid){
        try{
            if(!Auth::check()){
                return response()->json([
                    'message' => 'not logged in',
                ], 400);
            }
            if(Auth::user()->blocked === true){
                return response()->json([
                    'message' => 'user is blocked',
                ], 400);
            }
            $question = Question::find($questionid);
            if($question === null || $question->commentable->content->deleted === true){
                return response()->json([
                    'message' => 'question is deleted or cannot be found, cannot add correct answer',
                ], 400);
            }
            $this->authorize('correctanswer', $question);
            if($question->correct_answer_id !== null){
                if($question->correct_answer_id === $request->input('answerid')){
                    $question->correct_answer_id = null;
                    $question->save();
                    return response()->json([
                        'answerid' => $request->input('answerid'),
                        'message' => 'removed correct answer',
                    ], 200);
                }
            }
            $question->correct_answer_id = $request->input('answerid');
            $question->save();
            return response()->json([
                'answerid' => $request->input('answerid'),
                'message' => 'added correct answer',
            ], 200);
        }catch(Exception $e){
            return response()->json([
                'message' => 'error',
            ], 500);
        }    
    }
}