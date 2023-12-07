<?php
namespace App\Http\Controllers;
use Illuminate\Pagination\Paginator;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class SearchQuestionController extends Controller
{   

    public function show()
    {
        if( Auth::check()){
            $questions = Question::select('question.title', 'content.content', 'appuser.username', 'content.date', 'content.id as id', 'appuser.id as userid', 'content.votes')
            ->join('content', 'question.id', '=', 'content.id')
            ->join('appuser', 'content.user_id', '=', 'appuser.id')
            ->get();
            return view('pages.questions', ['questions' => $questions]);
        } else {
            return redirect('/login');
        }
    }
    public function search(Request $request)
    {
        // Implement your search logic here
        if (! auth::check()){
            response()->json([
                'message' => 'Not logged in',
            ], 302);
        }
        $query = $request->input('q');
        $sortby = $request->input('OrderBy');
        if($sortby == 'relevance'){
            if($query == null){

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
                ->paginate(15)->withQueryString()->withQueryString();

                foreach($results as $result){
                    $result->date = $result->commentable->content->compileddate();
                }
            return response()->json($results);
            }
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
            ->whereRaw("question.tsvectors @@ plainto_tsquery(?)", [$query])
            ->where('content.deleted', '=', false)
            ->groupBy(
                'question.tsvectors',
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
            ->orderByRaw("ts_rank(question.tsvectors, plainto_tsquery(?)) ASC", [$query])
            ->paginate(15)->withQueryString()->withQueryString();

                foreach($results as $result){
                    $result->date = $result->commentable->content->compileddate();
                }
            return response()->json($results);
        }else{
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
            ->where('question.title', 'ILIKE', "%$query%")
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
            ->orderBy($sortby, 'desc')
            ->paginate(10)->withQueryString()->withQueryString();

                foreach($results as $result){
                    $result->date = $result->commentable->content->compileddate();
                }
            return response()->json($results);
        }
    }
}

