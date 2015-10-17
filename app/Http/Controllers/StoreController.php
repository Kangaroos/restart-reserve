<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Store;

class StoreController extends Controller
{
    public function index(Request $request) {

        // 获取排序条件
        $orderColumn = $request->get('sort_up', $request->get('sort_down', 'created_at'));
        $direction   = $request->get('sort_up') ? 'asc' : 'desc' ;

        $stores = Store::orderBy($orderColumn, $direction)->paginate(999);;

        return view('mobile.stores', compact('stores', 'query'));
    }
    public function show($id) {
        $store = Store::find($id);
        return response()->json($store);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function getClassroomsByID(Request $request, $id) {
        $is_select = $request->input('is_select');

        $classrooms = DB::table('classrooms')->where('store_id', $id)->where('deleted_at', null);
        if($is_select === 1) {
            $classrooms->select('id', 'name');
        }
        $classrooms = $classrooms->get();

        return response()->json($classrooms);
    }
}
