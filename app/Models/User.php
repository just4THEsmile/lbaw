<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\FileController;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'bio',
        'points',
        'nquestion',
        'nanswer',
        'profilepicture',
        'paylink',
        'usertype'
    ];

    protected $table = 'appuser';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];
    
    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'badgeattainment', 'user_id', 'badge_id');
    }
    public function badgeAttainments()
    {
        return $this->hasMany(BadgeAttainment::class);
    }
    public function questions()
    {
        return Question::select('content.content as content', 'question.title as title', 'content.votes as votes', 'content.id as id', 'content.date as date')
            ->join('content', 'content.id', '=', 'question.id')
            ->join('commentable', 'commentable.id', '=', 'content.id')
            ->where('content.user_id', $this->id)
            ->orderBy('content.date','desc')
            ->get();
            
    }

    public function answers()
    {
        return Answer::select('content.content as content','question.id as question_id','question.title as title', 'content.votes as votes', 'content.id as id', 'content.date as date')
            ->join('question', 'question.id','=', 'answer.question_id')
            ->join('commentable', 'commentable.id', '=', 'answer.id')
            ->join('content', 'content.id', '=', 'commentable.id')
            ->where('content.user_id', $this->id)
            ->orderBy('content.date','desc')
            ->get();
    }

    public function getProfileImage() {
        return FileController::get('profile', $this->id);
    }

    public function VotedUP($content_id){
        $vote = DB::table('vote')->where('user_id', $this->id)->where('content_id', $content_id)->where('vote', 1)->first();
        if($vote === null){
            return false;
        }
        return true;
    }

    public function reports(){
        return $this->hasMany(Report::class, 'user_id', 'id');
    }
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }
}

