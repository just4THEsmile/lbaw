<span class="comment" data-id="{{$comment->id}}">
    <label>
        <span class="commentText">{{ $comment->content->content }}</span>
            @if ($comment->content->user->id === auth()->user()->id || auth()->user()->usertype === 'admin' || auth()->user()->usertype === 'moderator')
                @include('partials.editcomment', ['comment' => $comment])
            @endif
    </label>
</span>