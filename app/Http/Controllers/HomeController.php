<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Faq;
    /**
     * Display the home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    use App\Models\Question;
    use App\Models\User;

    class HomeController extends Controller
    {
        public function index()
        {
        $questions = Question::all();
        foreach($questions as $result){
            $result->date = $result->commentable->content->compileddate();
        }
            return view('pages.homequestions', ['questions' => $questions]);
        }

        public function users()
        {
            $users = User::all(); 
    
            return view('users.index', compact('users')); 
        }
        
        public function faq()
        {
            $faqs = Faq::all();
            return view('pages.faq', ['faqs' => $faqs]);
        }
    }
