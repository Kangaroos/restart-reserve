<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Store;
use Carbon\Carbon;

class CourseController extends Controller
{
    public function getCoursesByStoreId(Request $request, $id) {
        $dates = array();
        $now = Carbon::now();
        $dates['today'] = '今天'.$now->format('m-d');
        $dates['tomorrow'] = '明天'.$now->addDays(1)->format('m-d');
        $dates['day_after_tomorrow'] = '后天'.$now->addDays(2)->format('m-d');

        $store = Store::find($id);
        return view('mobile.courses', compact('store', 'dates'));
    }
}
