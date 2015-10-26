<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Validator;
use Toplan\Sms\Sms;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('sms', function($attribute, $value, $parameters) {
            try {
                $sms = Sms::where('to', $value)->orderBy('id', 'desc')->firstOrFail();
                $dt = Carbon::now();
                $sentTime = Carbon::createFromTimestamp($sms->sent_time);
                $second = $dt->diffInSeconds($sentTime);
                if($second < 40) {
                    return false;
                }
                return true;
            } catch(ModelNotFoundException $e) {
                return true;
            }
        });

        Validator::extend('mobile', function($attribute, $value, $parameters) {
            return preg_match('/^1[3|4|5|7|8|][0-9]{9}$/', $value);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
