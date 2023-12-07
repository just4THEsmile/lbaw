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
            $results = Question::select(
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
            ->orderBy('date', 'desc')
            ->paginate(15);
            return view('pages.homequestions', ['questions' => $results]);
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
