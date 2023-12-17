@extends('layouts.app')

@section('content')
    <form method="post" action="{{ route('tagcreate') }}" style="border:1px solid black;" onsubmit="disableSubmitButton()">
        @csrf
        <div class="form-group">
            @if ($errors->has('title'))
                <span class="error">
                    {{ $errors->first('title') }}
                </span>
            @endif
            <label for="title">Title:</label>
            <textarea class="form-control" id="title" name="title" rows="1" required></textarea>
            @if ($errors->has('description'))
                <span class="error">
                    {{ $errors->first('description') }}
                </span>
            @endif
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary" style="background-color:black; border:black;">Submit</button>
    </form>
@endsection