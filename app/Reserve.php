<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reserve extends Model
{
    protected $table = 'reserves';

    protected $fillable = ['order_no', 'course_schedule_id', 'user_id', 'seat_number', 'status', 'remark'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function courseSchedule()
    {
        return $this->belongsTo('App\CourseSchedule');
    }

    public function displayStatus() {
        switch($this->attributes['status']) {
            case 'verify':
                return '待核销';
                break;
            case 'complete':
                return '已核销';
                break;
            case 'cancel':
                return '已取销';
                break;
        }
    }

    public function cssStatus() {
        switch($this->attributes['status']) {
            case 'verify':
                return '';
                break;
            case 'complete':
                return ' history';
                break;
            case 'cancel':
                return ' history';
                break;
        }
    }

    public function isCancelTime() {
        $reserveDateTime = new Carbon(date('Y-m-d', strtotime($this->courseSchedule->attributes["class_date"]))." ".$this->courseSchedule->course->attributes["class_time_begin"]);
        $reserveDateTime = $reserveDateTime->subHours(2);
        return Carbon::now()->diffInHours($reserveDateTime, false) <= 0?"disabled":"";
    }
}
