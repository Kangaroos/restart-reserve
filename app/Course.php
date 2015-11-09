<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Scalar\String_;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = ['name', 'store_id', 'store_name', 'coach_id', 'coach_name', 'classroom_id', 'classroom_name', 'class_date', 'class_time_begin',  'class_time_end', 'week', 'description',  'needing_attention', 'status'];

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
        $datetimeStr = $datetimeStr.$date->format('m月d日')." ".$this->attributes['week']." ".$this->attributes['class_time_begin'];

        return $datetimeStr;
    }

    public function getClassTimeBeginAttribute() {
        return date('H:i', strtotime($this->attributes['class_time_begin']));
    }

    public function getClassTimeEndAttribute() {
        return date('H:i', strtotime($this->attributes['class_time_end']));
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
