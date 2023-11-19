<article class="question" data-id="{{ $question->id }}">
    <header>
    <h2><a href="/questions/{{ $question->id }}">{{ $question->title }}</a></h2>
    <h3><a href="/questions/{{ $question->id }}">{{ $question->commentable->content->content}}</a></h3>
    <form id='createquestion' action="./{{ $question->id }}/answer" method='get'>
        @csrf
        <button type='submit' class='createquestionButton' name="createquestion-button">New Answer</button>
    </form>
        <?php if($question->commentable->content->user->id === auth()->user()->id) {?>
            @include('partials.editquestion', ['question' => $question])
        <?php } ?>
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