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

    // If the query is empty, return all users
    if (strlen($query) == 0) {
        $results = User::all();
    } else {
        // Use where() with the 'like' operator to search usernames containing the query string
        $results = User::where('username', 'ilike', "%$query%")->get();
    }

    return response()->json($results);
    }

    public function getUsers(){

        $users = User::all();
        return view('pages.users', ['users' => $users]);

    }
    
}