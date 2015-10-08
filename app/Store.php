<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'stores';

//    protected $dateFormat = 'U';

    protected $fillable = ['name', 'mobile', 'address', 'description', 'lat', 'lng', 'startup_at', 'status'];

    protected $hidden = ['deleted_at'];

    public function classrooms()
    {
        return $this->hasMany('App\Classroom');
    }

    public function courses()
    {
        return $this->hasMany('App\Course');
    }
}
