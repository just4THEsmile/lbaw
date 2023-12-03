<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\Paginator;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Question;
class TagController extends Controller
{   
    public function search(Request $request)
    {
        $query = $request->input('query');
        // Use where() with the 'like' operator to search usernames containing the query string
        if(Auth::check()){
            $results = Tag::where('title','ILIKE',"%$query%" )->limit(10)->get();
            return response()->json($results);
        } else {
            return response()->json([
                'message' => 'Not logged in',
            ], 302);
        }
    }
    public function getTagsOfQuestion(Request $request, $id )
    {
        if(Auth::check()){
            $results = Tag::join('questiontag', 'tag.id', '=', 'questiontag.tag_id')
            ->Where('questiontag.question_id', '=', $id)
            ->get();//fix query to not return tags already in question

            return response()->json( $results);
        }else{
            return response()->json([
                'message' => 'Not logged in',
            ], 302);
        }
    }
    public function searchWithoutLimits(Request $request){
        $query = $request->input('query');
        if (Auth::check()) {
            if($query == null){
                $results = Tag::simplePaginate(15)->withqueryString();
                return response()->json($results);
            }
            $results = Tag::whereRaw("tsvectors @@ to_tsquery(?)", [str_replace(' ', ' & ', $query)])
            ->orderByRaw("ts_rank(tsvectors, to_tsquery(?)) ASC", [str_replace(' ', ' & ',$query)])->simplePaginate(15)->withqueryString();
            return response()->json($results);
        } else {
            return response()->json([
                'message' => 'Not logged in',
            ], 302);
        }
    }
    public function tagspage(){
        if(Auth::check()){
            return view("pages.tagsearch");
        } else {
            return redirect('/login');
        }

    }
    public function tagquestionspage($id){
        if(Auth::check()){
            return view("pages.tagquestionsearch",['tag_id' => $id]);
        } else {
            return redirect('/login');
        }

    }
    public function tagquestions(Request $request, $tag_id){
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
                ->join('questiontag', 'questiontag.question_id', '=', 'question.id')
                ->leftjoin('answer', 'answer.question_id', '=', 'question.id')
                ->leftjoin(
                    DB::raw('(SELECT question.id as qid, STRING_AGG(tag.title, \',\' ORDER BY tag.id ASC) as title, STRING_AGG(CAST(tag.id AS TEXT), \',\' ORDER BY tag.id ASC) as id FROM questiontag JOIN tag ON tag.id = questiontag.tag_id JOIN question ON question.id = questiontag.question_id GROUP BY question.id) as tags_agg'),
                    'tags_agg.qid',
                    '=',
                    'question.id'
                )
                ->where('questiontag.tag_id', '=', $tag_id)
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
            ->join('questiontag', 'questiontag.question_id', '=', 'question.id')
            ->leftjoin('answer', 'answer.question_id', '=', 'question.id')
            ->leftjoin(
                DB::raw('(SELECT question.id as qid, STRING_AGG(tag.title, \',\' ORDER BY tag.id ASC) as title, STRING_AGG(CAST(tag.id AS TEXT), \',\' ORDER BY tag.id ASC) as id FROM questiontag JOIN tag ON tag.id = questiontag.tag_id JOIN question ON question.id = questiontag.question_id GROUP BY question.id) as tags_agg'),
                'tags_agg.qid',
                '=',
                'question.id'
            )
            ->where('questiontag.tag_id', '=', $tag_id)
            ->whereRaw("question.tsvectors @@ to_tsquery(?)", [str_replace(' ', ' & ', $query)])
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
            ->orderByRaw("ts_rank(question.tsvectors, to_tsquery(?)) ASC", [$query])
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
            ->join('questiontag', 'questiontag.question_id', '=', 'question.id')
            ->leftjoin('answer', 'answer.question_id', '=', 'question.id')
            ->leftjoin(
                DB::raw('(SELECT question.id as qid, STRING_AGG(tag.title, \',\' ORDER BY tag.id ASC) as title, STRING_AGG(CAST(tag.id AS TEXT), \',\' ORDER BY tag.id ASC) as id FROM questiontag JOIN tag ON tag.id = questiontag.tag_id JOIN question ON question.id = questiontag.question_id GROUP BY question.id) as tags_agg'),
                'tags_agg.qid',
                '=',
                'question.id'
            )
            ->where('questiontag.tag_id', '=', $tag_id)
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