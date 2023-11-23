<?php

namespace App\Http\Controllers;
use App\Http\Controllers\TransactionsController;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Question;
use App\Models\Content;
use App\Models\Commentable;

class QuestionController extends Controller
{
    public function show(string $id): View
    {
        // Get the question.
        $question = Question::findOrFail($id);
        // Check if the current user can see (show) the question.
        $this->authorize('show', $question);  

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
        // Create a blank new question.
        $question = new Question();

        // Check if the current user is authorized to create this question.
        $this->authorize('create', $question);

        // Save the question and return it as JSON.
        $question = TransactionsController::createQuestion(Auth::user()->id,$request->input('title'),$request->input('content'));
        if($question === null){
            return redirect('/home');
        }
        return redirect("/question/". $question->id);
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
        $result = TransactionsController::editQuestion($question->id,$request->input('title'),$request->input('content'));
        if($result === null){
            return redirect('/question/'. $question->id);
        }
        return redirect('/question/' . $question->id);
    }

}