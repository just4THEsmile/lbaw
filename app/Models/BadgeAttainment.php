<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\HasMany;

class BadgeAttainment extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $BadgeAttainment = [
        'user_id',
        'badge_id',
        'date'
    ];

    protected $table = 'faq';
    protected $primaryKey = ['user_id', 'badge_id']; 

    /*

    public function user()
    {
        return $this->belongsTo(AppUser::class, 'user_id');
    }

    public function badge()
    {
        return $this->belongsTo(Badge::class, 'badge_id');
    }
    */
}
