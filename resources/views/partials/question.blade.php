<article class="question" data-id="{{ $question->id }}">
    <header>
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
                <a href="{{ url('/profile/'.$question->userid) }}">{{ $question->commentable->content->user->username }}</a>
                <p>{{ $question->date }}</p>
            </div>
            @include('partials.question_buttons', ['question' => $question])
        @endif
    </div>
    </header>
    <div class = "comments">
    @each('partials.comment', $question->commentable->comments()->orderBy('id')->get(), 'comment')
    </div>
    <ul>
    @each('partials.answer', $answers, 'answer')
    <?php // 

    //    @each('partials.answer',DB::table('answer')->where('question_id', $question->commentable_id)->get(), 'answer') 
    //
    ?>
    </ul>
</article>