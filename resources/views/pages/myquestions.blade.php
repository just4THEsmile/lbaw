@extends('layouts.barebone')

@section('content')


    @php
        $user = Auth::user();
        $questions = $user->questions();
    @endphp
    @if($questions->isEmpty())
        <p>No questions found.</p>
    @else
        <ul>
            @foreach($questions as $question)
            <li>Title: {{ $question->title }}, Content: {{ $question->content }}</li>
            @endforeach
        </ul>
    @endif
@endsection