<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Commentable extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    

    protected $table = 'commentable';
    protected $primaryKey = 'content_id';
    public function content() : BelongsTo
    {
        return $this->belongsTo(Content::class,'content_id');
    }

    public function Comments(): HasMany
    {
        return $this->hasMany(Comment::class,'commentable_id','content_id');
    }
}