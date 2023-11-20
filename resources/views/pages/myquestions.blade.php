<<<<<<< HEAD
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
=======
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
>>>>>>> 724ec5d460922cb5fe6a8d6832400ebf2cf16e81
@endsection