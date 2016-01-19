<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Scalar\String_;

class CourseSchedule extends Model
{
    protected $table = 'course_schedules';

    protected $fillable = ['course_id', 'class_date', 'week', 'status'];

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function reserves() {
        return $this->hasMany('App\Reserve');
    }

    public function classDateTime()
    {
        $datetimeStr = "";
        $date = Carbon::createFromTimestamp(strtotime($this->attributes['class_date']));
        if($date->isToday()) {
            $datetimeStr = '今天';
        } else if($date->isTomorrow()) {
            $datetimeStr = '明天';
        } else if($date->toDateString() === Carbon::tomorrow()->addDay()->toDateString()) {
            $datetimeStr = '后天';
        }
        $datetimeStr = $datetimeStr.$date->format('m月d日')." ".$this->attributes['week']." ".$this->course->attributes['class_time_begin'];

        return $datetimeStr;
    }

    public function getClassDateAttribute() {
        return date('Y-m-d', strtotime($this->attributes['class_date']));
    }

    public function unavailable() {
        $seats = array();
        $reserves = $this->reserves;
        foreach($reserves as $reserve) {
            array_push($seats,$reserve->seat_number);
        }
        return json_encode($seats);
    }
}
