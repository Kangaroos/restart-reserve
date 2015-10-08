<?php

namespace App\Http\Controllers\Admin;

use App\Classroom;
use App\Store;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ClassroomController extends Controller
{
    public function index(Request $request) {

        // 获取排序条件
        $orderColumn = $request->get('sort_up', $request->get('sort_down', 'created_at'));
        $direction   = $request->get('sort_up') ? 'asc' : 'desc' ;

        $classrooms = Classroom::orderBy($orderColumn, $direction)->paginate(999);;

        $stores = json_encode(DB::table('stores')->where('deleted_at', null)->select('id', 'name')->get());

        return view('admin.classroom.list', compact('classrooms', 'stores', 'query'));
    }
    public function show($id) {
        $classrooms = Classroom::find($id);
        return response()->json($classrooms);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $classrooms = new Classroom;
        $classrooms->fill($request->all());

        $classrooms->save();

        return response()->json(['id' => $classrooms->id]);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'name' => 'required'
        ]);

        $classrooms = Classroom::find($id);
        $classrooms->fill($request->all());

        $classrooms->save();

        return response()->json(['id' => $classrooms->id]);
    }

    public function destroy($id)
    {
        $classrooms = Classroom::find($id);

        $classrooms->delete();
        return response()->json(['id' => $id]);
    }
}
