@extends('layouts.app')

@section('content')
<form >
    </form>
        <div id="error"></div>
            <div class="form-group">
                <div id="titleError" class="error"></div>
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
            <span id="contentError" class="error"></span>
                <label for="content">Content:</label>
                <textarea class="form-control" id="questionContent" name="content" rows="4" required></textarea>
            </div>
            <div id="selectedtags">
            </div>
            <div id="errorAddTag" class="error"></div>
            <input type="text" class="form-control" id="TagsInput" name="title" value="" required>
            <div id="autocomplete"></div>
            <button id="submitbutton" class="btn btn-primary">Submit</button>

    <script type="text/javascript" src={{ url('js/create_question_form.js') }} defer></script>
@endsection