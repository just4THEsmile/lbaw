@extends('layouts.app')

@section('content')
    <form method="post" action="{{answer->id}}/co">
        @csrf
        <div class="form-group">
            <label for="content">Content:</label>
            <textarea class="form-control" id="content" name="content" rows="4"required>{{ $comment->content->content}}</textarea>
        </div>


        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection