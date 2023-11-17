<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionTag extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'questiontag';
    protected $primaryKey = ['question_id', 'tag_id'];
    /*
    public function question()
    {
        return $this->belongsTo(Question::class, 'commentable_id');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'id');
    }
    */
}