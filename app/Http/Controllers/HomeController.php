<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

    /**
     * Display the home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    use App\Models\Question;

    class HomeController extends Controller
    {
        public function index()
        {
            $questions = DB::select('
            SELECT Question.title, Content.content, AppUser.username, Content.date, Content.id as id, AppUser.id as userid, Content.votes
            FROM Question, Content, AppUser
            WHERE Question.id = Content.id AND Content.user_id = AppUser.id
        ');
            return view('pages.homequestions', ['questions' => $questions]);
        }
    }
