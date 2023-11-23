@extends('layouts.app')

@section('content')
    <form name="formEdit" onsubmit="return submitAction()">
        @csrf
        <input id="questionid" hidden value="{{ $question->id }}">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $question->title}}" ?>required>
        </div>

        <div class="form-group">
            <label for="content">Content:</label>
            <textarea class="form-control" id="content" name="content" rows="4" required>{{ $question->commentable->content->content}}</textarea>
        </div>
        <input type="text" class="form-control" id="TagsInput" name="title" value="" ?>required>
        <div id="autocomplete"></div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <script type="text/javascript" src={{ url('js/autocomplete_tags.js') }} defer></script>
@endsection