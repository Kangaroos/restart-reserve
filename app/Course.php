<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = ['name', 'store_id', 'store_name', 'coach_id', 'coach_name', 'classroom_id', 'classroom_name', 'class_date', 'class_time_begin',  'class_time_end', 'week', 'description',  'needing_attention'];

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
