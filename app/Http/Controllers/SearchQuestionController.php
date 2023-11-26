<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\Paginator;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SearchQuestionController extends Controller
{   

    public function show()
    {
        $questions = Question::select('question.title', 'content.content', 'appuser.username', 'content.date', 'content.id as id', 'appuser.id as userid', 'content.votes')
        ->join('content', 'question.id', '=', 'content.id')
        ->join('appuser', 'content.user_id', '=', 'appuser.id')
        ->get();
        return view('pages.questions', ['questions' => $questions]);
    }
    public function search(Request $request)
    {
        // Implement your search logic here
        
        $query = $request->input('q');
        $sortby = $request->input('OrderBy');
        if(strlen($query) == 0){
            $results= Question::select('question.title', 'content.content', 'appuser.username', 'content.date', 'content.id as id', 'appuser.id as userid', 'content.votes as votes')
            ->join('content', 'question.id', '=', 'content.id')
            ->join('appuser', 'content.user_id', '=', 'appuser.id')
            ->where('content.deleted', '=', False)
            ->orderBy($sortby,'desc')
            ->get();
            
            foreach($results as $result){
                $result->date = $result->commentable->content->compileddate();
            }
            return response()->json($results);
        }
            $results = Question::select('question.title', 
            'content.content', 
            'appuser.username', 
            'content.date', 
            'content.id as id', 
            'appuser.id as userid', 
            'content.votes as votes',
            DB::raw('STRING_AGG(tag.title, \',\' ORDER BY tag.id ASC) as tags'))
            ->join('content', 'question.id', '=', 'content.id')
            ->join('appuser', 'content.user_id', '=', 'appuser.id')
            ->join('questiontag', 'questiontag.question_id', '=', 'question.id')
            ->join('tag', 'tag.id', '=', 'questiontag.tag_id')
            ->where('question.title', 'ILIKE', "%$query%")
            ->where('content.deleted', '=', False)
            ->groupBy(
                'question.title',
                'content.content',
                'appuser.username',
                'content.date',
                'content.id',
                'appuser.id',
                'content.votes'
            )
            ->orderBy($sortby,'desc')
            ->get();
            foreach($results as $result){
                $result->date = $result->commentable->content->compileddate();
            }
        return response()->json($results);
    }
}
    /* works but not with ajax
    $query = $request->get('query');
    if ($request->ajax()) {
        $data = Question::where('title', 'LIKE', $query . '%')
            ->limit(10)
            ->get();
        $output = '';
        if (count($data) > 0) {
            $output = '<ul class="list-group">';
            foreach ($data as $row) {
                $output .= '<li class="list-group-item">' . $row->title . '</li>';
            }
            $output .= '</ul>';
        } else {
            $output .= '<li class="list-group-item">' . 'No results' . '</li>';
        }
        return $output;
    }
    $questions = User::where('title', 'LIKE', '%' . $query . '%')
    ->simplePaginate(10);
    return view('welcome', compact('questions'));*/

