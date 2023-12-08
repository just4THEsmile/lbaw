<div class="card">
    <h2 class="card-title">Blocked Comment</h2>
    <p class="card-text">Content: {{$block->content}}</p>
    <p class="card-date">{{$block->date}}</p>
    <a href="/api/unblockrequest/{{ $block->id }}?user_id={{ $block->user_id }}" class="btn btn-unblock">Request Unblock</a>
</div>