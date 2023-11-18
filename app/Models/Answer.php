<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'answer';
    protected $primaryKey = 'commentable_id';

    
    public function commentable(): BelongsTo
    {
        return $this->belongsTo(Commentable::class,'commentable_id');
    }

    public function question() : BelongsTo
    {
        return $this->belongsTo(Commentable::class, 'question_id','commentable_id');
    }
    
    
}