<?php

namespace App\Http\Controllers;

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
        $courses = array();
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        $day_after_tomorrow = Carbon::tomorrow()->addDay();

        $dates['today'] = '今天'.$today->format('m-d');
        $dates['tomorrow'] = '明天'.$tomorrow->format('m-d');
        $dates['day_after_tomorrow'] = '后天'.$day_after_tomorrow->format('m-d');

        $store = Store::find($id);

        $courses['today'] = Course::where('class_date', $today->format('Y-m-d'))->where('status', 'approved')->orderBy('created_at', 'desc')->get();
        $courses['tomorrow'] = Course::where('class_date', $tomorrow->format('Y-m-d'))->where('status', 'approved')->orderBy('created_at', 'desc')->get();
        $courses['day_after_tomorrow'] = Course::where('class_date', $day_after_tomorrow->format('Y-m-d'))->where('status', 'approved')->orderBy('created_at', 'desc')->get();
        return view('mobile.courses', compact('store', 'courses', 'dates'));
    }

    public function getCourseReserveById(Request $request, $id) {
        $course = Course::find($id);
        return view('mobile.courses.reserve', compact('course'));
    }
}
