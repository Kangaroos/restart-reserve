<?php

namespace App\Http\Controllers\Admin;

use App\CourseSchedule;
use Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use App\Course;

class CourseController extends Controller
{
    public function index(Request $request) {

        // 获取排序条件
        $orderColumn = $request->get('sort_up', $request->get('sort_down', 'created_at'));
        $direction   = $request->get('sort_up') ? 'asc' : 'desc' ;

        $courses = Course::orderBy($orderColumn, $direction)->paginate(8);

        $stores = json_encode(DB::table('stores')->where('deleted_at', null)->select('id', 'name')->get());
        $coaches = json_encode(DB::table('coaches')->where('deleted_at', null)->select('id', 'name')->get());

        return view('admin.course.list', compact('courses', 'stores', 'classrooms', 'coaches', 'query'));
    }

    public function show($id) {
        $course = Course::find($id);
        $courseSchedules = $course->schedules;
        $course->toJson();
        $course['schedules'] = $courseSchedules->toJson();
        return response($course);
    }

    public function store(Request $request) {
        $inputs = $request->all();

        $course = new Course;
        $course->fill($inputs);
        $course->save();

        return $course->id;
    }

    public function update(Request $request, $id){
        $courses = Course::find($id);
        $courses->fill($request->all());

        $courses->save();

        return response()->json(['id' => $courses->id]);
    }

    public function destroy($id)
    {
        $courses = Course::find($id);
        $courses->schedules()->delete();
        $courses->delete();
        return response()->json(['id' => $id]);
    }

    public function checkCourse(Request $request) {
        $data = $request->all();
        $courseLength = DB::table('courses')
            ->leftJoin('course_schedules', 'courses.id', '=', 'course_schedules.course_id')
            ->where('courses.classroom_id', '=', $data['classroom_id'])
            ->where('course_schedules.class_date', '=', $data['class_date'])
            ->Where(function ($query) use ($data) {
                $query->where('courses.class_time_begin', '<=', $data['class_time_begin'])
                    ->where('courses.class_time_end', '>=', $data['class_time_begin']);
            })
            ->Where(function ($query) use ($data) {
                $query->where('courses.class_time_begin', '<=', $data['class_time_end'])
                    ->where('courses.class_time_end', '>=', $data['class_time_end']);
            })
            ->count();
        return $courseLength>0?response()->json(['status' => false]):response()->json(['status' => true]);
    }

    public function getCourseSchedules($id) {
        $courseSchedules = CourseSchedule::where('course_id', $id)->get();
        return response()->json($courseSchedules);
    }

    public function saveCourseSchedules(Request $request, $id) {
        $schedule = $request->all();
        $courseSchedule = new CourseSchedule;
        $courseSchedule['course_id'] = $id;
        $courseSchedule['status'] = 'approved';
        $courseSchedule->fill($schedule);
        $courseSchedule->save();
        return $courseSchedule->id;
    }

    public function updateCourseSchedule(Request $request, $id) {
        $courseSchedule = CourseSchedule::find($id);
        $courseSchedule->fill($request->all());

        $courseSchedule->save();

        return response()->json(['id' => $courseSchedule->id]);
    }

    public function destroyCourseSchedule($id)
    {
        $courseSchedule = CourseSchedule::find($id);
        $courseSchedule->delete();
        return response()->json(['id' => $id]);
    }
}
