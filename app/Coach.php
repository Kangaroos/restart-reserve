<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coach extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'coaches';

    protected $fillable = ['name', 'description', 'status'];

    public function courses()
    {
        return $this->hasMany('App\Course');
    }
}
