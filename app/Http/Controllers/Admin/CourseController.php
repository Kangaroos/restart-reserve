<?php

namespace App\Http\Controllers\Admin;

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
        return response()->json($course);
    }

    public function store(Request $request) {
        $datas = $request->input('courses');
        $datas = json_decode($datas,true);

        $ids = [];

        foreach($datas as $data) {
            $data = array_except($data, ['_id']);
            $course = new Course;
            $course->fill($data);
            $course->save();
            array_push($ids,$course->id);
        }

        return $ids;
    }

    public function checkCourse(Request $request) {
        $data = $request->all();
        $courseLength = DB::table('courses')
            ->where('classroom_id', '=', $data['classroom_id'])
            ->where('class_date', '=', $data['class_date'])
            ->Where(function ($query) use ($data) {
                $query->where('class_time_begin', '<=', $data['class_time_begin'])
                    ->where('class_time_end', '>=', $data['class_time_begin']);
            })
            ->Where(function ($query) use ($data) {
                $query->where('class_time_begin', '<=', $data['class_time_end'])
                    ->where('class_time_end', '>=', $data['class_time_end']);
            })
            ->count();
        return $courseLength>0?response()->json(['status' => false, 'id' => $data['_id']]):response()->json(['status' => true, 'id' => $data['_id']]);
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

        $courses->delete();
        return response()->json(['id' => $id]);
    }
}
