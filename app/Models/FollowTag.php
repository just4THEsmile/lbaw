<?php

namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Builder;
class FollowTag extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'followtag';
    protected $fillable = [
        'user_id',
        'tag_id'
    ];
    protected $primaryKey = ['user_id', 'tag_id'];
    public $incrementing = false;
    /**
 * Set the keys for a save update query.
 *
 * @param  \Illuminate\Database\Eloquent\Builder  $query
 * @return \Illuminate\Database\Eloquent\Builder
 */
protected function setKeysForSaveQuery($query)
{
    $keys = $this->getKeyName();
    if(!is_array($keys)){
        return parent::setKeysForSaveQuery($query);
    }

    foreach($keys as $keyName){
        $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
    }

    return $query;
}

/**
 * Get the primary key value for a save query.
 *
 * @param mixed $keyName
 * @return mixed
 */
protected function getKeyForSaveQuery($keyName = null)
{
    if(is_null($keyName)){
        $keyName = $this->getKeyName();
    }

    if (isset($this->original[$keyName])) {
        return $this->original[$keyName];
    }

    return $this->getAttribute($keyName);
}
    
}
