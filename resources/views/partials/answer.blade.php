
<span class="answer" data-id="{{$answer->id}}">
    <label>
        <span>{{ $answer->commentable->content->content }}</span>
        @if ($answer->commentable->content->user->id === auth()->user()->id || auth()->user()->usertype === 'admin' || auth()->user()->usertype === 'moderator')
            @include('partials.editanswer', ['answer' => $answer,'answer' => $answer])
        @endif
    </label>
</span>
<span class="comments">
    @each('partials.comment', $answer->commentable->comments()->orderBy('id')->get(), 'comment')
</span>

