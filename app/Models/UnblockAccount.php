<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnblockAccount extends Model
{
    public $timestamps  = false;

    protected $fillable = [
        'user_id',
        'appeal'
    ];

    protected $table = 'unblockaccount';
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
