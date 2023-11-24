<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Question extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'title'
    ];
    protected $table = 'question';
    protected $primaryKey = 'id';
    
    public function commentable(): BelongsTo
    {
        return $this->belongsTo(Commentable::class,'id','id');
    }
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
    public function questionTags(): HasMany
    {
        return $this->hasMany(QuestionTag::class);
    }
    public function Tags()
    {   
        return Tag::join('questiontag','questiontag.tag_id','=','tag.id')->where('questiontag.question_id','=',$this->id)->get();
    }
}