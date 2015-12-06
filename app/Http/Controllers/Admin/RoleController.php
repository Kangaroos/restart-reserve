<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Kodeine\Acl\Models\Eloquent\Role;

class RoleController extends Controller
{
    public function index(Request $request) {
        // 获取排序条件
        $orderColumn = $request->get('sort_up', $request->get('sort_down', 'created_at'));
        $direction   = $request->get('sort_up') ? 'asc' : 'desc' ;

        $roles = Role::orderBy($orderColumn, $direction)->paginate(999);

        return view('admin.role.list', compact('roles', 'query'));
    }

    public function show($id) {
        $role = Role::find($id);
        return response()->json($role);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'name' => 'required'
        ]);

        $role = Role::find($id);
        $role->fill($request->all());

        $role->save();

        return response()->json(['id' => $role->id]);
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();
        return response()->json(['id' => $id]);
    }
}
