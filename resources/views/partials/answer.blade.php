@php
use App\Enums\vote;
$vote = $answer->commentable->content->get_vote();
@endphp
<span class="answer" data-id="{{$answer->id}}">
    @if(!$answer->commentable->content->deleted)
        <div class="correctbutton" id = "{{ $answer->id }}">
            @if ($answer->commentable->content->user->id === auth()->user()->id || auth()->user()->usertype === 'admin')
                <button type='submit' id="{{ $answer->id }}" class='correctanswerButton' name="correctanswer-button">
                    <span class="material-symbols-outlined">
                        check
                    </span>
                </button>
            @endif
        </div>
        <div class="correct" id= "{{ $answer->id }}"> 
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
                <button type="submit" class="arrow-up voted" id = "{{ $answer->id }}">
                    <span class="material-symbols-outlined">
                        expand_less 
                    </span>
                </button>
                <p class="votesnum" class=>{{ $answer->commentable->content->votes }}</p> 
                <button type = "submit" class="arrow-down" id = "{{ $answer->id }}">
                    <span class="material-symbols-outlined">
                        expand_more 
                    </span>
                </button>
            </div>
        @elseif ($vote == App\Enums\vote::VOTEDOWN)
            <div class="votes" >
                <button type="submit" class="arrow-up" id = "{{ $answer->id }}">
                    <span class="material-symbols-outlined">
                        expand_less 
                    </span>
                </button>
                <p class="votesnum" class=>{{ $answer->commentable->content->votes }}</p> 
                <button type = "submit" class="arrow-down voted" id = "{{ $answer->id }}">
                    <span class="material-symbols-outlined">
                        expand_more 
                    </span>
                </button>
            </div>
        @else        
        <div class="votes" >
            <button type="submit" class="arrow-up" id = "{{ $answer->id }}">
                <span class="material-symbols-outlined">
                    expand_less 
                </span>
            </button>
        <p class="votesnum" class=>{{ $answer->commentable->content->votes }}</p> 
            <button type = "submit" class="arrow-down" id = "{{ $answer->id }}">
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
                    <form id='createcomment' action="{{ route('create_comment_form',['id' => $answer->id]) }}" method='get'>
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
</span>
<span class="comments">
    @each('partials.comment', $answer->commentable->comments()->orderBy('id')->get(), 'comment')
</span>

