<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Question;

class QuestionController extends Controller
{
    public function show(string $id): View
    {
        // Get the question.
        $question = Question::findOrFail($id);
        // Check if the current user can see (show) the card.
        $this->authorize('show', $question);  

        // Use the pages.card template to display the card.
        return view('pages.question', [
            'question' => $question
        ]);
    }
    //isto vai dar trabalho
    //isto vai dar trabalho
    //isto vai dar trabalho
    //isto vai dar trabalho
    //isto vai dar trabalho
    /*
    public function listuserquestions()
    {
        // Check if the user is logged in.
        if (!Auth::check()) {
            // Not logged in, redirect to login.
            return redirect('/login');

        } else {
            // The user is logged in.

            // Get cards for user ordered by id.
            $questions = Question::orderBy('id')->get();
            // Check if the current user can list the cards.
            $this->authorize('list', Question::class);

            // The current user is authorized to list cards.

            // Use the pages.cards template to display all cards.
            return view('pages.cards', [
                'question' => $question,
                'answers' => $answers
            ]);
        }
    }*/
}