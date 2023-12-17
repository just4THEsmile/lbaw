<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\HasMany;

class Badge extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description'
    ];

    protected $table = 'badge';

    public function users()
    {
        return $this->belongsToMany(User::class, 'badgeattainment', 'badge_id', 'user_id');
    }
    public function badgeattainment()
    {
        return $this->hasMany(BadgeAttainment::class, 'badge_id', 'id');
    }
}
