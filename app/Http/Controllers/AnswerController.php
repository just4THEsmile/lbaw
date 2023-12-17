<?php

namespace App\Http\Controllers;
use App\Http\Controllers\TransactionsController;
use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Answer;
use App\Models\Content;
use App\Models\Commentable;
use App\Models\Question;
class AnswerController extends Controller
{
    /**
     * Creates a new Answer.
     */
    public function createform(string $id){
        if (!Auth::check()) {
            return redirect('/login');
        }
        if(Auth::user()->blocked === true){
            return redirect('/home');
        }
        return view('pages.answercreate', [
            'question_id' => $id
        ]);

    }
    public function create(Request $request,string $id)
    {
        // Create a blank new Answer.
        $answer = new Answer();
        if (!Auth::check()) {
            return redirect('/login');
        }
        $question = Question::find($id);
        if($question === null){
            return redirect()->route('home')->withErrors(['page' => 'The provided question does not exist.']);
        }
        if(Auth::user()->blocked === true){
            return redirect()->route('home')->withErrors(['page' => 'You are blocked u can t answer questions.']);
        }
        // Check if the current user is authorized to create this Answer.
        $this->authorize('create', $answer);

        // Save the Answer and return it as JSON.
        $answer = TransactionsController::createAnswer(Auth::user()->id,$id,$request->input('content'));
        if($answer === null){
            return redirect()->route('question_show',['id' => $id])->withErrors(['question' => 'There was an error when creating the answer.']);
        }
        return redirect("/question/". $id);
    }

    /**
     * Delete a Answer.
     */
    public function delete(Request $request, string $id,string $answer_id)
    {
        // Find the Answer.
        $answer = Answer::find($answer_id);
        if($answer === null){
            return redirect('/home');
        }
        if (!Auth::check()) {
            return redirect('/login');
        }
        if(Auth::user()->blocked === true){
            return redirect('/home');
        }
        // Check if the current user is authorized to delete this Answer.
        $this->authorize('delete', $answer);
        $content1 = Content::find($answer->id);
        // Delete the question and return it as JSON.
        //probably transaction
        $content1->content ="Deleted";
        $content1->deleted = true;
        $content1->save();
        return redirect("/question/". $id);
    }
    public function editform(string $id,string $answer_id){
        if (!Auth::check()) {
            return redirect('/login');
        }
        if(Auth::user()->blocked === true){
            return redirect('/home');
        }
        $answer = Answer::find($answer_id);
        if($answer === null){
            return redirect()->route('home')->withErrors(['page' => 'The provided answer does not exist.']);
        }
        return view('pages.answeredit', [
            'answer' => $answer
        ]);
    }

    public function edit(Request $request, string $id , string $answer_id)
    {
        // Find the Answer.
        $answer = Answer::find($answer_id);
        if(!Auth::check()){
            return redirect('/login');
        }
        if($answer === null){
            return redirect()->route('home')->withErrors(['page' => 'The provided answer does not exist.']);
        }
        if(Auth::user()->id !== $answer->user_id && Auth::user()->usertype !== 'admin' && Auth::user()->usertype !== 'moderator' ){
            return redirect('/home');
        }
        if(Auth::user()->blocked === true){
            return redirect('/home');
        }
        // Check if the current user is authorized to delete this Answer.
        $this->authorize('edit', $answer);
        $content1 = Content::find($answer->id);
        // Delete the question and return it as JSON.
        //probably transaction
        $content1->content =$request->input('content');
        $content1->edited = true;
        $content1->date = now();
        $content1->save();
        return redirect('/question/' . $answer->question_id);
    }
}