<article class="question" data-id="{{ $question->id }}">
    <header>
        <h2><a href="/questions/{{ $question->id }}">{{ $question->title }}</a></h2>
        <a href="#" class="delete">&#10761;</a>
    </header>
    <ul>
        @each('partials.anwser', $question->Awnsers()->orderBy('id')->get(), 'anwser')
    </ul>
    <form class="new_item">
        <input type="text" name="description" placeholder="new item">
    </form>
</article>