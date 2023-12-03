<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\HasMany;

class BadgeAttainmentNotification extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'notification_id','user_id', 'badge_id'
    ];

    protected $table = 'badgeattainmentnotification';
    protected $primaryKey = ['notification_id','user_id', 'badge_id'];
    public function badge() : BelongsTo
    {
        return $this->belongsTo(Badge::class);
    }
    public function notification() : BelongsTo
    {
        return $this->belongsTo(Notification::class);
    }
}
