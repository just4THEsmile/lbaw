<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class CommentNotification extends Model
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
        'comment_id',

    ];

    protected $table = 'commentnotification';
    protected $primaryKey = 'notification_id';
    /*
    public function notification()
    {
        return $this->belongsTo(Notification::class, 'id');
    }

    public function comment()
    {
        return $this->belongsTo(Question::class, 'comment_id');
    }
    */
    public function comment() : BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
    public function notification() : BelongsTo
    {
        return $this->belongsTo(Notification::class);
    }
}