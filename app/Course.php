<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Scalar\String_;
use Illuminate\Support\Facades\DB;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = ['name', 'store_id', 'store_name', 'coach_id', 'coach_name', 'classroom_id', 'classroom_name', 'class_time_begin',  'class_time_end', 'week', 'description',  'needing_attention', 'status'];

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

    public function schedules() {
        return $this->hasMany('App\CourseSchedule');
    }

    public function getClassTimeBeginAttribute() {
        return date('H:i', strtotime($this->attributes['class_time_begin']));
    }

    public function getClassTimeEndAttribute() {
        return date('H:i', strtotime($this->attributes['class_time_end']));
    }
}
