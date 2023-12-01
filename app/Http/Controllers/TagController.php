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
    // If the query is empty, return all users
    if (strlen($query) == 0) {
        $results = Tag::limit(10)->get();//fix query to not return tags already in question
    } else {
        // Use where() with the 'like' operator to search usernames containing the query string
        $results = Tag::where('title','ILIKE',"%$query%" )->limit(10)->get();
    }

    return response()->json($results);
    }
    public function getTagsOfQuestion(Request $request, $id )
    {
        $results = Tag::join('questiontag', 'tag.id', '=', 'questiontag.tag_id')
        ->Where('questiontag.question_id', '=', $id)
        ->get();//fix query to not return tags already in question

        return response()->json( $results);
    }
    public function searchWithoutLimits(Request $request){
        $query = $request->input('query');
        if (strlen($query) == 0) {
            $results = Tag::paginate(15)->withqueryString();//fix query to not return tags already in question
        } else {
            // Use where() with the 'like' operator to search usernames containing the query string
            $results = Tag::where('title','ILIKE',"%$query%" )->paginate(15)->withqueryString();
        }
        return $results;
    }
    public function tagspage(){
        if(Auth::check()){
            return view("pages.tagsearch");
        } else {
            return redirect('/login');
        }

    }
 
    
}