<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    protected $table = 'reserves';

    protected $fillable = ['order_no', 'course_id', 'user_id', 'seat_number', 'status', 'remark'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
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
}
