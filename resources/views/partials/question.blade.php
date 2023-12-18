<article class="question" data-id="{{ $question->id }}">
    <header>
    @php
    use App\Enums\vote;
    $correct = null;
    $vote = $question->commentable->content->get_vote();
    if($question->correct_answer_id != null){
        $correct = $question->correct_answer_id;
    }

    @endphp
    @if (!$question->commentable->content->deleted)
        @if ($vote == vote::VOTEUP)
            <div class="votes" >
                <button type="submit" class="arrow-up voted" id = "{{ $question->id }}">
                    <span class="material-symbols-outlined">
                        expand_less 
                    </span>
                </button>
                <p class="votesnum" class=>{{ $question->commentable->content->votes }}</p> 
                <button type = "submit" class="arrow-down" id = "{{ $question->id }}">
                    <span class="material-symbols-outlined">
                        expand_more 
                    </span>
                </button>
            </div>
        @elseif ($vote == App\Enums\vote::VOTEDOWN)
            <div class="votes" >
                <button type="submit" class="arrow-up" id = "{{ $question->id }}">
                    <span class="material-symbols-outlined">
                        expand_less 
                    </span>
                </button>
                <p class="votesnum" class=>{{ $question->commentable->content->votes }}</p> 
                <button type = "submit" class="arrow-down voted" id = "{{ $question->id }}">
                    <span class="material-symbols-outlined">
                        expand_more 
                    </span>
                </button>
            </div>
        @else        
        <div class="votes" >
            <button type="submit" class="arrow-up" id = "{{ $question->id }}">
                <span class="material-symbols-outlined">
                    expand_less 
                </span>
            </button>
        <p class="votesnum" class=>{{ $question->commentable->content->votes }}</p> 
            <button type = "submit" class="arrow-down" id = "{{ $question->id }}">
                <span class="material-symbols-outlined">
                    expand_more 
                </span>
            </button>
        </div>
        @endif
    @endif
    <div class="questioncontent">
        <h2>{{ $question->title }}</h2>
        @if (!$question->commentable->content->deleted)
            @if($question->commentable->content->edited )
                <p class="edittag">edited</p>
            @endif
        @endif    
        <h3>{{ $question->commentable->content->content}}</h3>
        @if (!$question->commentable->content->deleted)
            <div class="questioninfo">
            <div class="profileinfo">
                <a href="{{ url('/profile/'.$question->commentable->content->user->id) }}">{{ $question->commentable->content->user->username }}</a>
                <p>{{ $question->date }}</p>
            </div>
            @if (!auth()->user()->blocked)
                @include('partials.question_buttons', ['question' => $question])
            @endif
        @endif
    </div>
    </header>
    <div class = "comments">
    @each('partials.comment', $question->commentable->comments()->orderBy('id')->get(), 'comment')
    </div>
    <ul>
    @foreach ($answers as $answer)
        @include('partials.answer', ['answer' => $answer, 'correct' => $correct])
    @endforeach
    </ul>
</article>