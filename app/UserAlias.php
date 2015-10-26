<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAlias extends Model
{
    protected $table = 'user_aliases';

    protected $fillable = ['user_id', 'provider', 'alias', 'type', 'data'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
