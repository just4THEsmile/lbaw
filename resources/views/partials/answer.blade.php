
<span class="answer" data-id="{{$answer->id}}">
    <label>
        <span>{{ $answer->commentable->content->content }}</span>
        <?php if($answer->commentable->content->user->id === auth()->user()->id) {?>
            <a href="#" class="delete">&#10761;</a>
        <?php } ?>
    </label>
</span>
<span class="comments">
    @each('partials.comment', $answer->commentable->comments()->orderBy('id')->get(), 'comment')
</span>

