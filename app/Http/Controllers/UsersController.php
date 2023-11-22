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
    $sortBy = $request->input('sortBy');

    if (strlen($query) == 0) {
        $results = User::all();
    } else {
        $results = User::where('username', 'ilike', "%$query%")->get();
    }

    if($sortBy == 'name'){
        $results = $results->orderBy('name', 'desc');
    } else if($sortBy == 'points'){
        $results = $results->orderBy('points', 'desc');
    } else if($sortBy == 'username'){
        $results = $results->orderBy('', 'desc');
    }
    return response()->json($results);
    }

    public function getUsers(){

        $users = User::all();
        return view('pages.users', ['users' => $users]);

    }
    
}