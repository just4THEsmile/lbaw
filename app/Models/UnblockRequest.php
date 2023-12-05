<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnblockRequest extends Model
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
        'content_id',
        'description'
    ];

    protected $table = 'unblockrequest';
    protected $primaryKey = 'id';
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    

    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }
}