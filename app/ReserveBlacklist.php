<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReserveBlacklist extends Model
{
    protected $table = 'reserve_blacklist';

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
