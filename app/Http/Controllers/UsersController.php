<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\Paginator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{   

    public function show()
    {
        $questions = User::select('question.title', 'content.content', 'appuser.username', 'content.date', 'content.id as id', 'appuser.id as userid', 'content.votes')
        ->join('content', 'question.id', '=', 'content.id')
        ->join('appuser', 'content.user_id', '=', 'appuser.id')
        ->get();

        return view('pages.questions', ['questions' => $questions]);
    }
    public function search(Request $request)
    {
        // Implement your search logic here
        
        $query = $request->input('q');
        if(strlen($query) == 0){
            $results= User::select('question.title', 'content.content', 'appuser.username', 'content.date', 'content.id as id', 'appuser.id as userid', 'content.votes')
            ->join('content', 'question.id', '=', 'content.id')
            ->join('appuser', 'content.user_id', '=', 'appuser.id')
            ->get();
            return response()->json($results);
        }
            $results = User::select('question.title', 'content.content', 'appuser.username', 'content.date', 'content.id as id', 'appuser.id as userid', 'content.votes')
            ->join('content', 'question.id', '=', 'content.id')
            ->join('appuser', 'content.user_id', '=', 'appuser.id')
            ->where('question.title', 'ILIKE', "%$query%")
            ->get();
        return response()->json($results);
    }
}