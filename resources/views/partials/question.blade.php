<article class="question" data-id="{{ $question->id }}">
    <header>
    <h2>{{ $question->title }}</h2>
    <h3>{{ $question->commentable->content->content}}</h3>
    @if (!$question->commentable->content->deleted)
        <div class="questionbuttons">
            <form id='createanswer' action="./{{ $question->id }}/answer" method='get'>
                @csrf
                <button type='submit' class='createquestionButton' name="createquestion-button">New Answer</button>
            </form>
            <form id='createcomment' action="{{ route('create_comment_form',['id' => $question->id]) }}" method='get'>
                @csrf
                <button type='submit' class='createcommentButton' name="createcomment-button">New Comment</button>
            </form>
            @if ($question->commentable->content->user->id === auth()->user()->id || auth()->user()->usertype === 'admin' || auth()->user()->usertype === 'moderator')
                @include('partials.editquestion', ['question' => $question])
            @endif
            <form id='followquestion' action="{{ $question->id }}/followquestion" method=POST>
                @csrf
                @if ($question->isFollowed(auth()->user()))
                    <button type='submit' class='unfollowquestionButton' name="followquestion-button">Unfollow Question</button>
                @else
                    <button type='submit' class='followquestionButton' name="followquestion-button">Follow Question</button>
                @endif
            </form>
            <form  class='report' action="{{route('report',['content_id'=> $question->commentable->content->id])}}" method='post'>
                @csrf
                @if ($question->commentable->content->isReported(auth()->user()))
                    <button type='submit' class='unreportButton' name="unreport-button">Unreport Question</button>
                @else
                    <button type='submit' class='reportButton' name="report-button">Report Question</button>
                @endif
            </form>
        </div>

    @endif
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