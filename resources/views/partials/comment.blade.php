<span class="comment" data-id="{{$comment->id}}">
    <label>
        <span class="commentText">{{ $comment->content->content }}</span>
        <?php if($comment->content->user->id === auth()->user()->id) {?>
            @include('partials.editcomment', ['comment' => $comment])
        <?php } ?>
    </label>
</span>