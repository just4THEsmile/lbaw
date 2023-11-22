<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\Paginator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UsersController extends Controller
{   
    public function search(Request $request)
    {
    $query = $request->input('q');
    $searchBy = $request->input('SearchBy');
    // If the query is empty, return all users
    if (strlen($query) == 0) {
        $results = User::where('name','<>','Deleted')->get();
    } else {
        // Use where() with the 'like' operator to search usernames containing the query string
        $results = User::where($searchBy, 'ilike', "%$query%")->where('name','<>','Deleted')->get();
    }

    return response()->json($results);
    }
 
    public function getUsers(){

        $users = User::all();
        return view('pages.users', ['users' => $users]);

    }
    
}