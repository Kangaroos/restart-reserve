<?php

namespace App\Http\Controllers;

use App\CourseSchedule;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Store;
use App\Course;
use Carbon\Carbon;

class CourseController extends Controller
{
    public function getCoursesByStoreId(Request $request, $id) {
        $dates = array();
        $courseSchedules = array();
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        $day_after_tomorrow = Carbon::tomorrow()->addDay();

        $dates['today'] = '今天'.$today->format('m-d');
        $dates['tomorrow'] = '明天'.$tomorrow->format('m-d');
        $dates['day_after_tomorrow'] = '后天'.$day_after_tomorrow->format('m-d');

        $store = Store::find($id);

        $courseSchedules['today'] = CourseSchedule::whereHas('course', function($query) use($store) {
            $query->where('store_id', $store->id);
        })->where('class_date', $today->format('Y-m-d'))->where('status', 'approved')->orderBy('created_at', 'desc')->get();
        $courseSchedules['tomorrow'] = CourseSchedule::whereHas('course', function($query) use($store) {
            $query->where('store_id', $store->id);
        })->where('class_date', $tomorrow->format('Y-m-d'))->where('status', 'approved')->orderBy('created_at', 'desc')->get();
        $courseSchedules['day_after_tomorrow'] = CourseSchedule::whereHas('course', function($query) use($store) {
            $query->where('store_id', $store->id);
        })->where('class_date', $day_after_tomorrow->format('Y-m-d'))->where('status', 'approved')->orderBy('created_at', 'desc')->get();
        return view('mobile.courses', compact('store', 'courseSchedules', 'dates'));
    }

    public function getCourseReserveById(Request $request, $id) {
        $courseSchedule = CourseSchedule::find($id);
        return view('mobile.courses.reserve', compact('courseSchedule'));
    }
}
