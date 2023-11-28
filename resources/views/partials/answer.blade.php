
<span class="answer" data-id="{{$answer->id}}">
    <div>
        <span>{{ $answer->commentable->content->content }}</span>
        @if(!$answer->commentable->content->deleted)
            <div class= "commentbuttons">
                <form id='createcomment' action="{{ route('create_comment_form',['id' => $answer->id]) }}" method='get'>
                    @csrf
                    <button type='submit' class='createcommentButton' name="createcomment-button">New Comment</button>
                </form>
                @if ($answer->commentable->content->user->id === auth()->user()->id || auth()->user()->usertype === 'admin' || auth()->user()->usertype === 'moderator')
        
                @include('partials.editanswer', ['answer' => $answer,'answer' => $answer])
                @endif
            </div>    
        @endif
</div>
</span>
<span class="comments">
    @each('partials.comment', $answer->commentable->comments()->orderBy('id')->get(), 'comment')
</span>

