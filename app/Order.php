<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'orders';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function reserve()
    {
        return $this->belongsTo('App\Reserve');
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
    }
}
