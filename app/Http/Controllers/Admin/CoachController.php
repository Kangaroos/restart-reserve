<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Coach;

class CoachController extends Controller
{
    public function index(Request $request) {

        // 获取排序条件
        $orderColumn = $request->get('sort_up', $request->get('sort_down', 'created_at'));
        $direction   = $request->get('sort_up') ? 'asc' : 'desc' ;

        $coaches = Coach::orderBy($orderColumn, $direction)->paginate(999);;

        return view('admin.coach.list', compact('coaches', 'query'));
    }
    public function show($id) {
        $coaches = Coach::find($id);
        return response()->json($coaches);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $coaches = new Coach;
        $coaches->fill($request->all());

        $coaches->save();

        return response()->json(['id' => $coaches->id]);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'name' => 'required'
        ]);

        $coaches = Coach::find($id);
        $coaches->fill($request->all());

        $coaches->save();

        return response()->json(['id' => $coaches->id]);
    }

    public function destroy($id)
    {
        $coaches = Coach::find($id);

        $coaches->delete();
        return response()->json(['id' => $id]);
    }
}
