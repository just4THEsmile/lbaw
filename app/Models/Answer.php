<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\HasMany;

class Answer extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'commentable_id',
        'question_id'
    ];

    protected $table = 'answer';
    protected $primaryKey = ['commentable_id', 'question_id'];

    /*
    public function commentable()
    {
        return $this->belongsTo(Commentable::class, 'content_id');
    }

    public function question()
    {
        return $this->belongsTo(Commentable::class, 'content_id');
    }
    */
    
}