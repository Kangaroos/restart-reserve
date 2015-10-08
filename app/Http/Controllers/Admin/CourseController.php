<?php

namespace App\Http\Controllers\Admin;

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

        $courses = Course::orderBy($orderColumn, $direction)->paginate(999);

        $stores = json_encode(DB::table('stores')->where('deleted_at', null)->select('id', 'name')->get());
        $coaches = json_encode(DB::table('coaches')->where('deleted_at', null)->select('id', 'name')->get());

        return view('admin.course.list', compact('courses', 'stores', 'classrooms', 'coaches', 'query'));
    }

    public function show($id) {
        $courses = Course::find($id);
        return response()->json($courses);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $courses = new Course;
        $courses->fill($request->all());

        $courses->save();

        return response()->json(['id' => $courses->id]);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'name' => 'required'
        ]);

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
