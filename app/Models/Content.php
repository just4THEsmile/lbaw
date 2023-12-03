<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\vote;
use App\Models\Vote as ModelsVote;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon; // Added to use Carbon date formatting.
// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\HasMany;

class Content extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'content'];
    protected $table = 'content';
    
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function get_vote() : Vote {
        $vote = ModelsVote::where('user_id', auth()->user()->id)->where('content_id', $this->id)->first();
        if ($vote == null) {
            return Vote::NONE;
        }
        else if ($vote->vote == True) {
            return Vote::VOTEUP;
        }
        else {
            return Vote::VOTEDOWN;
        }
    }
    
    public function isReported(User $user) : bool
    {
        return $user->reports()->where('content_id', $this->id)->exists();
    }
    
    public function compileddate() : string
    {
        $someDate = Carbon::parse($this->date);
        $deltaTime = $someDate->diffForHumans(); // This gives you a human-readable delta time

        return $deltaTime;
    }
}