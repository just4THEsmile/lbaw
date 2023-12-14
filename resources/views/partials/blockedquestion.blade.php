<div class="card">
    <h2 class="card-title">Blocked Question</h2>
    <h3 class="card-subtitle">Title: {{$block->question->title}}</h3>
    <p class="card-text">Content: {{$block->content}}</p>
    <p class="card-date">{{$block->date}}</p>
    <a href="/api/unblockrequest/{{ $block->id }}?user_id={{ $block->user_id }}" style="border: black;color:white !important;display: flex;align-items: center;background-color:black" class="btn btn-unblock">Request Unblock</a>
</div>