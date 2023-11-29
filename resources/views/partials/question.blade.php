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
                <div class="questionbuttons">
                    <form id='createanswer' action="./{{ $question->id }}/answer" method='get' onsubmit="disableSubmitButton()">
                        @csrf
                        <button type='submit' class='createquestionButton' name="createquestion-button">New Answer</button>
                    </form>
                    <form id='createcomment' action="{{ route('create_comment_form',['id' => $question->id]) }}" method='get' onsubmit="disableSubmitButton()">
                        @csrf
                        <button type='submit' class='createcommentButton' name="createcomment-button">New Comment</button>
                    </form>
                    @if ($question->commentable->content->user->id === auth()->user()->id || auth()->user()->usertype === 'admin' || auth()->user()->usertype === 'moderator')
                        @include('partials.editquestion', ['question' => $question])
                    @endif
                    @if ($question->commentable->content->user_id != auth()->user()->id)
                        <form id='followquestion' action="{{ $question->id }}/followquestion" method=POST onsubmit="disableSubmitButton()">
                            @csrf
                            @if ($question->isFollowed(auth()->user()))
                                <button type='submit' class='unfollowquestionButton' name="followquestion-button">Unfollow Question</button>
                            @else
                                <button type='submit' class='followquestionButton' name="followquestion-button">Follow Question</button>
                            @endif
                    
                        </form>
                        <form  class='report' action="{{route('report',['content_id'=> $question->commentable->content->id])}}" method='post' onsubmit="disableSubmitButton()">
                            @csrf
                            @if ($question->commentable->content->isReported(auth()->user()))
                                <button type='submit' class='unreportButton' name="unreport-button">Unreport</button>
                            @else
                                <button type='submit' class='reportButton' name="report-button">Report</button>
                            @endif
                        </form>
                    @endif

                </div>
        @endif
    </div>
    </header>
    <div class = "comments">
    @each('partials.comment', $question->commentable->comments()->orderBy('id')->get(), 'comment')
    </div>
    <ul>
    @each('partials.answer', $question->answers()->orderBy('id')->get(), 'answer')
    <?php // 

    //    @each('partials.answer',DB::table('answer')->where('question_id', $question->commentable_id)->get(), 'answer') 
    //
    ?>
    </ul>
</article>