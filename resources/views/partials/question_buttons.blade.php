<div class="questionbuttons">
    <form action="./{{ $question->id }}/answer" method='get'>
        @csrf
        <button type='submit' class='createquestionButton' name="createquestion-button">New Answer</button>
    </form>
    <form action="{{ route('create_comment_form',['id' => $question->id]) }}" method='get' >
        @csrf
        <button type='submit' class='createcommentButton' name="createcomment-button">New Comment</button>
    </form>
    @if ($question->commentable->content->user->id === auth()->user()->id || auth()->user()->usertype === 'admin' || auth()->user()->usertype === 'moderator')
        @include('partials.editquestion', ['question' => $question])
    @endif
    @if ($question->commentable->content->user_id != auth()->user()->id)
        <form  action="{{ $question->id }}/followquestion" method=POST>
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
                <button type='submit' class='unreportButton' name="unreport-button">Unreport</button>
            @else
                <button type='submit' class='reportButton' name="report-button">Report</button>
            @endif
        </form>
    @endif

</div>