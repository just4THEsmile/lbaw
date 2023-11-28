<span class="comment" data-id="{{$comment->id}}">
    <div>
        <span class="commentText">{{ $comment->content->content }}</span>
            @if (($comment->content->user->id === auth()->user()->id || auth()->user()->usertype === 'admin' || auth()->user()->usertype === 'moderator' ) && !$comment->content->deleted)
                @include('partials.editcomment', ['comment' => $comment])
            @endif
</div>
</span>