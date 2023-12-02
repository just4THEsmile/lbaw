<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\Paginator;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
                $results = Tag::paginate(15)->withqueryString();
                return response()->json($results);
            }
            $results = Tag::whereRaw("tsvectors @@ to_tsquery(?)", [str_replace(' ', ' & ', $query)])
            ->orderByRaw("ts_rank(tsvectors, to_tsquery(?)) ASC", [$query])->paginate(15)->withqueryString();
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
 
    
}