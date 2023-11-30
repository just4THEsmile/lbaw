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

class QuestionController extends Controller
{
    public function show(string $id): View
    {
        // Get the question.
        $question = Question::findOrFail($id);
        // Check if the current user can see (show) the question.
        $this->authorize('show', $question);  

            $question->date = $question->commentable->content->compileddate();


        // Use the pages.question template to display the question.
        return view('pages.question', [
            'question' => $question
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
        if(sizeof(explode(",", $request->input('tags'))) > 5){
            return response()->json([
                'message' => 'Too many tags',
            ],500);
        }
        //dd($request->input('tags'));
        $question = TransactionsController::createQuestion(Auth::user()->id,$request->input('title'),$request->input('content'),$request->input('tags'));
        if($question === null){
            return response()->json([
                //'message' => $request->input($result),
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
        $question = Question::findOrFail($id);
        if (Auth::check()) {
            return view('pages.questionedit', [
                'question' => $question
            ]);
        } else {
            return redirect('/login');
        }
    }
    public function edit(Request $request, $id)
    {
        // Find the question.
        $question = Question::find($id);

        // Check if the current user is authorized to delete this question.
        $this->authorize('edit', $question);
        if(sizeof(explode(",", $request->input('tags'))) > 5){
            return response()->json([
                'message' => 'Too many tags',
            ],500);
        }
        //dd($request->input('tags'));
        $result = TransactionsController::editQuestion($question->id,$request->input('title'),$request->input('content'),$request->input('tags'));
        if($result === null){
            return response()->json([
                'message' => $request->input('tags'),
            ], 404);
        }
        return response()->json($result);
    }

    public function follow(Request $request, $id){

        $question = Question::find($id);
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

}