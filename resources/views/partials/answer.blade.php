@php
use App\Enums\vote;
$vote = $answer->commentable->content->get_vote();
@endphp
<li class="answer" data-id="{{$answer->id}}">
    @if(!$answer->commentable->content->deleted)
        <div class="correctbutton" data-id  = "{{ $answer->id }}">
            @if ($question->commentable->content->user->id === auth()->user()->id || auth()->user()->usertype === 'admin')
                <button type='submit' data-id ="{{ $answer->id }}" class='correctanswerButton' name="correctanswer-button">
                    <span class="material-symbols-outlined">
                        check
                    </span>
                </button>
            @endif
        </div>
        <div class="correct" data-id= "{{ $answer->id }}"> 
            @if($correct!=null)
            @if($correct == $answer->id)
            <span class="material-symbols-outlined">
                check
            </span>
            @endif
        @endif   
        </div> 
        @if ($vote == vote::VOTEUP)
            <div class="votes" >
                <button type="submit" class="arrow-up voted" data-id = "{{ $answer->id }}">
                    <span class="material-symbols-outlined">
                        expand_less 
                    </span>
                </button>
                <p class="votesnum" class=>{{ $answer->commentable->content->votes }}</p> 
                <button type = "submit" class="arrow-down" data-id = "{{ $answer->id }}">
                    <span class="material-symbols-outlined">
                        expand_more 
                    </span>
                </button>
            </div>
        @elseif ($vote == App\Enums\vote::VOTEDOWN)
            <div class="votes" >
                <button type="submit" class="arrow-up" data-id= "{{ $answer->id }}">
                    <span class="material-symbols-outlined">
                        expand_less 
                    </span>
                </button>
                <p class="votesnum" class=>{{ $answer->commentable->content->votes }}</p> 
                <button type = "submit" class="arrow-down voted" data-id = "{{ $answer->id }}">
                    <span class="material-symbols-outlined">
                        expand_more 
                    </span>
                </button>
            </div>
        @else        
        <div class="votes" >
            <button type="submit" class="arrow-up" data-id = "{{ $answer->id }}">
                <span class="material-symbols-outlined">
                    expand_less 
                </span>
            </button>
        <p class="votesnum" class=>{{ $answer->commentable->content->votes }}</p> 
            <button type = "submit" class="arrow-down" data-id = "{{ $answer->id }}">
                <span class="material-symbols-outlined">
                    expand_more 
                </span>
            </button>
        </div>
        @endif
    @endif
    <div class="answercontent">
        @if (!$answer->commentable->content->deleted)
                @if($answer->commentable->content->edited )
                    <p class="edittag">edited</p>
                @endif
        @endif
        <span>{{ $answer->commentable->content->content }}</span>
        @if(!$answer->commentable->content->deleted)
            <div class="profileinfo">
                <a href="{{ url('/profile/'.$answer->commentable->content->user->id) }}">{{ $answer->commentable->content->user->username }}</a>
                <p>{{ $answer->commentable->content->compileddate()}}</p>
            </div>
            @if (!auth()->user()->blocked)
                <div class= "commentbuttons">
                    <form action="{{ route('create_comment_form',['id' => $answer->id]) }}" method='get'>
                        @csrf
                        <button type='submit' class='createcommentButton' name="createcomment-button">New Comment</button>
                    </form>
                    @if ($answer->commentable->content->user->id === auth()->user()->id || auth()->user()->usertype === 'admin' || auth()->user()->usertype === 'moderator')
            
                    @include('partials.editanswer', ['answer' => $answer,'answer' => $answer])
                    @endif
                    
                </div>   
            @endif
        @endif
</div>
</li>
<li class="comments">
    @each('partials.comment', $answer->commentable->comments()->orderBy('id')->get(), 'comment')
</li>

