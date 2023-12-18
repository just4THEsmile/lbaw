@extends('layouts.app')

@section('style')
<link href="{{ asset('css/createquestion.css') }}" rel="stylesheet">

@endsection

@section('content')
    <div class="sidebar">
        <a href="/home">Home Page</a>
        <a href="/feed">Feed</a>
        <a href="{{'/tags'}}">Tags</a>
        <a class="active" href="{{'/questions'}}">Questions</a>
        <a href="{{'/users'}}">Users</a>
        @if (Auth::check() && (Auth::user()->usertype == 'admin' || Auth::user()->usertype == 'moderator'))
            <a href="{{'/moderatecontent'}}">Blocked Content</a>
        @endif
    </div>
    <div class="create">
        <div class="forms">
            <form method="post" action="{{ route('create_comment',['id' => $commentable_id]) }}" onsubmit="disableSubmitButton()">
                @csrf
                @if ($errors->has('content'))
                    <span class="error">
                        {{ $errors->first('content') }}
                    </span>
                @endif
                <div class="form-group">
                    <label for="content">Create your Comment</label>
                    <textarea placeholder="Enter Your Comment Here" class="form-control" id="content" name="content" rows="4"required></textarea>
                </div>


                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection