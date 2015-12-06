<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Kodeine\Acl\Models\Eloquent\Permission;
use Kodeine\Acl\Models\Eloquent\Role;

class PermissionController extends Controller
{
    public function index(Request $request) {
        // 获取排序条件
        $orderColumn = $request->get('sort_up', $request->get('sort_down', 'created_at'));
        $direction   = $request->get('sort_up') ? 'asc' : 'desc' ;

        $permissions = Permission::orderBy($orderColumn, $direction)->paginate(999);

        return view('admin.permission.list', compact('permissions', 'query'));
    }

    public function show($id) {
        $permission = Permission::find($id);
        return response()->json($permission);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'name' => 'required'
        ]);

        $permission = Permission::find($id);
        $permission->fill($request->all());

        $permission->save();

        return response()->json(['id' => $permission->id]);
    }

    public function destroy($id)
    {
        $permission = Permission::find($id);
        $permission->delete();
        return response()->json(['id' => $id]);
    }
}
