<article class="question" data-id="{{ $question->id }}">
    <header>
    <h2><a href="/questions/{{ $question->id }}">{{ $question->title }}</a></h2>
        <h3><a href="/questions/{{ $question->id }}">{{ $question->commentable->content->content}}</a></h3>
        <?php if($question->commentable->content->user->id === auth()->user()->id) {?>
            <div class='right-card'>
                <form id='passwordform' action="{{ $question->id }}/delete" method='post'>
                    @csrf
                    <button type='submit' class='delete' name="delete-button">&#10761;</button>
                </form>
            </div> 
            <form class="new_item" method='post'>
                @csrf
                <button type='submit' class='delete' name="delete-button">&#10761;</button>
            </form>
        <?php } ?>
        <form class="new_item">
            <input type="text" name="description" placeholder="new item">
        </form>
    </header>
    <ul>
    @each('partials.answer', $question->answers()->orderBy('id')->get(), 'answer')
    <?php // 

    //    @each('partials.answer',DB::table('answer')->where('question_id', $question->commentable_id)->get(), 'answer') 
    //
    ?>
    </ul>
    <form class="new_item">
        <input type="text" name="description" placeholder="new item">
    </form>
</article>