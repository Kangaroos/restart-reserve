<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'classrooms';

    protected $fillable = ['name', 'description', 'store_id', 'seats', 'seats_map', 'status'];

    public function store()
    {
        return $this->belongsTo('App\Store');
    }

    public function courses()
    {
        return $this->hasMany('App\Course');
    }
}
