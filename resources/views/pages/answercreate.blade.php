@extends('layouts.app')

@section('style')

    
    <link href="{{ asset('css/users.css') }}" rel="stylesheet">
    <link href="{{ asset('css/search.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
@endsection

@section('content')
    <form method="post" action="./answer" onsubmit="disableSubmitButton()">
        @csrf
        <div class="form-group">
            <label for="content">Content:</label>
            <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
        </div>


        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection