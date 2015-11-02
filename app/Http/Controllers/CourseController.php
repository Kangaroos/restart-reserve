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
        $now = Carbon::now();
        $dates['today'] = '今天'.$now->format('m-d');
        $dates['tomorrow'] = '明天'.$now->addDays(1)->format('m-d');
        $dates['day_after_tomorrow'] = '后天'.$now->addDays(1)->format('m-d');

        $store = Store::find($id);
        return view('mobile.courses', compact('store', 'dates'));
    }

    public function getCourseReserveById(Request $request) {
        return view('mobile.courses.reserve');
    }

    public function getCourseReserveResultById(Request $request, $id) {
        return view('mobile.courses.reserve-result');
    }

    public function show(Request $request, $id) {
//        $course = Course::find($id);
//        $course = array();
//        return view('mobile.courses.show', compact('course'));
        return view('mobile.courses.show');
    }


}
