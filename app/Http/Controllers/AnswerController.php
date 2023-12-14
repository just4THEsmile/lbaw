<?php

namespace App\Http\Controllers;
use App\Http\Controllers\TransactionsController;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Answer;
use App\Models\Content;
use App\Models\Commentable;

class AnswerController extends Controller
{
    /**
     * Creates a new Answer.
     */
    public function createform(string $id){
        if (Auth::check()) {
            if(Auth::user()->blocked == true){
                return redirect('/home');
            }
            return view('pages.answercreate', [
                'question_id' => $id
            ]);
        } else {
            return redirect('/login');
        }

    }
    public function create(Request $request,string $id)
    {
        // Create a blank new Answer.
        $answer = new Answer();
        if (Auth::check()) {
            return redirect('/login');
        }
        if(Auth::user()->blocked == true){
            return redirect('/home');
        }
        // Check if the current user is authorized to create this Answer.
        $this->authorize('create', $answer);

        // Save the Answer and return it as JSON.
        $answer = TransactionsController::createAnswer(Auth::user()->id,$id,$request->input('content'));
        if($answer === null){
            return redirect('/question/2'. $id);
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
        if (Auth::check()) {
            return redirect('/login');
        }
        if(Auth::user()->blocked == true){
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
        if (Auth::check()) {
            return redirect('/login');
        }
        if(Auth::user()->blocked == true){
            return redirect('/home');
        }
        $answer = Answer::find($answer_id);
        if (Auth::check()) {
            return view('pages.answeredit', [
                'answer' => $answer
            ]);
        } else {
            return redirect('/login');
        }
    }

    public function edit(Request $request, string $id , string $answer_id)
    {
        // Find the Answer.
        $answer = Answer::find($answer_id);

        // Check if the current user is authorized to delete this Answer.
        $this->authorize('edit', $answer);
        $content1 = Content::find($answer->id);
        // Delete the question and return it as JSON.
        //probably transaction
        $content1->content =$request->input('content');
        $content1->edited = true;
        $content1->save();
        return redirect('/question/' . $answer->question_id);
    }
    //isto vai dar trabalho
    //isto vai dar trabalho
    //isto vai dar trabalho
    //isto vai dar trabalho
    //isto vai dar trabalho
    /*
    public function listuserAnswers()
    {
        // Check if the user is logged in.
        if (!Auth::check()) {
            // Not logged in, redirect to login.
            return redirect('/login');

        } else {
            // The user is logged in.

            // Get Answers for user ordered by id.
            $answers = Answer::orderBy('id')->get();
            // Check if the current user can list the Answers.
            $this->authorize('list', Answer::class);

            // The current user is authorized to list Answers.

            // Use the pages.Answers template to display all Answers.
            return view('pages.Answers', [
                'Answer' => $answer,
                'answers' => $answers
            ]);
        }
    }*/
}