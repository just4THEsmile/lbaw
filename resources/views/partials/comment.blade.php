<span class="comment" data-id="{{$comment->id}}">
    <div>
        @if (!$comment->content->deleted)
                @if($comment->content->edited )
                    <p class="edittag">edited</p>
                @endif
        @endif
        <span class="commentText">{{ $comment->content->content }}</span>
        <div class="profileinfo">
            <a href="{{ url('/profile/'.$comment->content->user->id) }}">{{ $comment->content->user->username }}</a>
            <p>{{ $comment->content->compileddate()}}</p>
        </div>
            @if (($comment->content->user->id === auth()->user()->id || auth()->user()->usertype === 'admin' || auth()->user()->usertype === 'moderator' ) && !$comment->content->deleted)
                @include('partials.editcomment', ['comment' => $comment])
            @endif
    </div>
</span>