<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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