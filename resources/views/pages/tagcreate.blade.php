@extends('layouts.app')
@section('pagename')
Create a Tag
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
    <h1 style="display:flex; justify-content: center;">Create a Tag</h1>
    <form method="post" action="{{ route('tagcreate') }}" style="padding:1em ; border:1px solid black; margin-top:1em;" onsubmit="disableSubmitButton()">
        <fieldset>
            <legend>Create a New Tag</legend>
            @csrf
            <div class="form-group">
                @if ($errors->has('title'))
                    <span class="error">
                        {{ $errors->first('title') }}
                    </span>
                @endif
                <label for="title">New Title:</label>
                <textarea placeholder="title" class="form-control" id="title" name="title" rows="1" required></textarea>
                @if ($errors->has('description'))
                    <span class="error">
                        {{ $errors->first('description') }}
                    </span>
                @endif
                <label for="description">New Description:</label>
                <textarea placeholder="description" class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="background-color:black; border:black;">Submit</button>
        </fieldset>    
    </form>
@endsection