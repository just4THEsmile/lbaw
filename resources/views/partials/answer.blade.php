
<li class="answer" data-id="{{$answer->id}}">
    <label>
        <span>{{ $answer->commentable->content->content }}</span>
        <?php if($answer->commentable->content->user->id === 2) {?>
            <a href="#" class="delete">&#10761;</a>
        <?php } ?>
    </label>
</li>
