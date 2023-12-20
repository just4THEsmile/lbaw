@extends('layouts.app')
@section('pagename')
Edit a Tag
@endsection 
@section('content')

<div class="sidebar">
    <a href="/home">Home Page</a>
    <a href="/feed">Feed</a>
    <a href="{{'/tags'}}">Tags</a>
    <a href="{{'/questions'}}">Questions</a>
    <a href="{{'/users'}}">Users</a>
    @if (Auth::check() && (Auth::user()->usertype == 'admin' || Auth::user()->usertype == 'moderator'))
        <a href="{{'/moderatecontent'}}">Blocked Content</a>
    @endif
</div>
    <form method="post" action="{{ route('tagedit',['id' => $tag->id]) }}" style=" border:1px solid black;margin-top:0em;" onsubmit="disableSubmitButton()">
    <fieldset>
            <legend>Edit Tag</legend>
        @csrf
        <div class="form-group">
            @if ($errors->has('title'))
                <span class="error">
                    {{ $errors->first('title') }}
                </span>
            @endif
            <label for="title">Title:</label>
            <textarea class="form-control" id="title" name="title" rows="1" required>{{$tag->title}}</textarea>
            @if ($errors->has('description'))
                <span class="error">
                    {{ $errors->first('description') }}
                </span>
            @endif
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="4" required>{{$tag->description}}</textarea>
        </div>
        <button type="submit" style="background-color:black; border:black;"class="btn btn-primary">Submit</button>
    </fieldset>
    </form>
@endsection