<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Coach;
use App\Excel\CoachListExport;

class CoachController extends Controller
{
    public function index(Request $request) {

        // 获取排序条件
        $orderColumn = $request->get('sort_up', $request->get('sort_down', 'created_at'));
        $direction   = $request->get('sort_up') ? 'asc' : 'desc' ;

        $coaches = Coach::orderBy($orderColumn, $direction)->paginate(8);

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

    public function exportExcel(CoachListExport $export) {
        return $export->sheet('教练列表', function($sheet)
        {
            $sheet->row(1, array(
                '编号', '姓名', '描述', '状态', '创建时间', '更新时间'
            ));
            $sheet->fromModel(Coach::all(), null, 'A2', false, false);
        })->download('xlsx');
    }
}
