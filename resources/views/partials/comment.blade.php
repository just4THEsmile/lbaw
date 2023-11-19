<span class="comment" data-id="{{$comment->id}}">
    <label>
        <span class="commentText">{{ $comment->content->content }}</span>
        <?php if($comment->content->user->id === auth()->user()->id) {?>
            <a href="#" class="delete">&#10761;</a>
        <?php } ?>
    </label>
</span>