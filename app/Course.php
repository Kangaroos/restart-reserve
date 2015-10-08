<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    public function store()
    {
        return $this->belongsTo('App\Store');
    }

    public function coach()
    {
        return $this->belongsTo('App\Coach');
    }

    public function classroom()
    {
        return $this->belongsTo('App\Classroom');
    }
}
