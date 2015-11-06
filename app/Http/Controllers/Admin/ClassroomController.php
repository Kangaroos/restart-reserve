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

        $data = $request->all();
        $seatStyle = $data['seats_style'];
        array_forget($data, 'seats_style');
        $classrooms = new Classroom;
        $classrooms->fill($data);
        if($seatStyle == 'rectangle') {
            $classrooms->seats_map = "['aaaa_','aaaa_','aaaaa','aaaa_','aaaaa','aaaa_','aaaa_','aaaa_','aaaa_','aaaaa','aaaa_','aaaa_','aaaaa']";
            $classrooms->seats = "{a: {classes : 'rectangle'}}";
        } else {
            $classrooms->seats_map = "['aaaaaaa','aaaaaaa','aaaaaaa','aaaaaaa','_aaaaaa','__aaaaa']";
            $classrooms->seats = "{a: {classes : 'triangle'}}";
        }

        $classrooms->save();

        return response()->json(['id' => $classrooms->id]);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'name' => 'required'
        ]);


        $data = $request->all();
        $seatStyle = $data['seats_style'];
        array_forget($data, 'seats_style');
        $classrooms = Classroom::find($id);
        $classrooms->fill($data);
        if($seatStyle == 'rectangle') {
            $classrooms->seats_map = "['aaaa_','aaaa_','aaaaa','aaaa_','aaaaa','aaaa_','aaaa_','aaaa_','aaaa_','aaaaa','aaaa_','aaaa_','aaaaa']";
            $classrooms->seats = "{a: {classes : 'rectangle'}}";
        } else {
            $classrooms->seats_map = "['aaaaaaa','aaaaaaa','aaaaaaa','aaaaaaa','_aaaaaa','__aaaaa']";
            $classrooms->seats = "{a: {classes : 'triangle'}}";
        }
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
