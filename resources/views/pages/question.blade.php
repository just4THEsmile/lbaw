<<<<<<< HEAD
@extends('layouts.app')

@section('content')
    <section id="answers">
        @include('partials.question', ['question' => $question])
    </section>
=======
@extends('layouts.app')

@section('title', $question->title)

@section('content')
    <section id="answers">
        @include('partials.question', ['question' => $question])
    </section>
>>>>>>> 724ec5d460922cb5fe6a8d6832400ebf2cf16e81
@endsection