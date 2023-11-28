<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// Added to define Eloquent relationships.

class AnswerNotification extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'notification_id',
        'answer_id'
    ];

    protected $table = 'answernotification';
    protected $primaryKey = 'notification_id';

    /*
    public function notification()
    {
        return $this->belongsTo(Notification::class, 'id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'commentable_id');
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class, 'commentable_id');
    }
    */
    public function answer() : BelongsTo
    {
        return $this->belongsTo(Answer::class);
    }
}