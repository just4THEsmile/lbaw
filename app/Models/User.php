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

    public function questions()
    {
        return DB::table('content')
            ->select('content.content as content', 'question.title as title', 'content.votes as votes', 'content.id as id', 'content.date as date')
            ->join('commentable', 'commentable.id', '=', 'content.id')
            ->join('question', 'question.id', '=', 'commentable.id')
            ->where('content.user_id', $this->id)
            ->get();
    }

    public function answers()
    {
        return DB::table('content')
            ->select('content.content as content', 'question.title as title', 'content.votes as votes', 'question.id as id', 'content.date as date')
            ->join('commentable', 'commentable.id', '=', 'content.id')
            ->join('answer', 'answer.id', '=', 'commentable.id')
            ->join('question', 'question.id', '=', 'answer.question_id')
            ->where('content.user_id', $this->id)
            ->get();
    }

    public function getProfileImage() {
        return FileController::get('profile', $this->id);
    }

    public function reports(){
        return $this->hasMany(Report::class, 'user_id', 'id');
    }
}

