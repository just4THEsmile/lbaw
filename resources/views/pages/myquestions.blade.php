@extends('layouts.barebone')

@section('content2')

    <style>
        #MyQuestions{
            background-color: #0000FF;
            
        }
        #MyQuestions > a{
            color:white;
        } 
    </style>
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