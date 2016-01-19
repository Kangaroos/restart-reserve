<?php

namespace App\Http\Controllers;

use App\Course;
use App\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Reserve;
use Toplan\Sms\Sms;

class ReserveController extends Controller
{
    public function store(Request $request) {
        $user = $request->user();
        $data = $request->only(['course_schedule_id', 'seat_number']);

        try {
            $reserve = Reserve::where('course_schedule_id', $data['course_schedule_id'])->firstOrFail();
            return back()
                ->withInput()
                ->with('error', '对不起，该课程您已预约！3秒后为您跳转结果页...')
                ->with('redirectUrl', route('reserve.result', $reserve->id));
        } catch(ModelNotFoundException $e) {
            $reserve = Reserve::create([
                'user_id' => $user->id,
                'course_schedule_id' => $data['course_schedule_id'],
                'seat_number' => $data['seat_number']
            ]);
            $now = Carbon::create();
            $reserve->order_no = rand(100000,999999).$now->format('ymd').$reserve->id;
            $reserve->save();
        }
        return response()->redirectToRoute('reserve.result',['reserve' => $reserve]);
    }

    public function cancelReserve(Request $request, $id) {
        $reserve = Reserve::find($id);
        $reserve->status = "cancel";
        $reserve->save();
        return response()->json(['success' => true]);
    }

    public function getReserveResultById(Request $request, $id) {
        $reserve = Reserve::find($id);
        return view('mobile.courses.reserve-result', compact('reserve'));
    }

    public function sendReserveSms(Request $request) {
        $data = $request->all();
        $sms = Sms::make(['Ucpaas' => '16058']);
        $template = '恭喜您，预订 %s 成功，课程时间 %s，核销码为 %s（用户签到时候使用）';
        $content  = vsprintf($template, $data);
        $result = $sms->to($data['mobile'])
        ->data(['course_name' => $data['course_name'], 'class_date' => $data['class_date'], 'order_no' => $data['order_no']])
        ->content($content)
        ->send();

        return response()->json(['success' => true]);
    }
}
