<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;

use App\User;
use App\Excel\UserListExport;

class UserController extends Controller
{
    public function index(Request $request) {
        // 获取排序条件
        $orderColumn = $request->get('sort_up', $request->get('sort_down', 'created_at'));
        $direction   = $request->get('sort_up') ? 'asc' : 'desc' ;

        $members = User::whereIn('level', ['003', '002'])->whereHas('roles', function ($query) {
            $query->where('slug', 'member');
        })->orderBy($orderColumn, $direction)->paginate(8);

        $nonMembers = User::where('level', '001')->whereHas('roles', function ($query) {
            $query->where('slug', 'member');
        })->orderBy($orderColumn, $direction)->paginate(8);

        return view('admin.user.list', compact('members', 'nonMembers', 'query'));
    }

    public function show($id) {
        $user = User::find($id);
        return response()->json($user);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'name' => 'required',
            'mobile' => 'required',
        ]);

        $user = User::find($id);
        $user->fill($request->all());

        $user->save();

        return response()->json(['id' => $user->id]);
    }

    public function audit(Request $request, $id){
        $user = User::find($id);
        $user->level = "003";
        $user->save();
        return response()->json(['id' => $user->id]);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();
        return response()->json(['id' => $id]);
    }

    public function exportExcel(UserListExport $export) {
        return $export->sheet('会员列表', function($sheet)
        {
            $sheet->row(1, array(
                '编号', '姓名', '昵称', '电话', '会员卡号', '爽约次数', '会员等级', '状态', '创建时间', '更新时间'
            ));
            $sheet->fromModel(User::all(), null, 'A2', false, false);
        })->download('xlsx');
    }

    public function changePwd(Request $request, Guard $auth) {
        $user = $auth->user();
        $user->password = bcrypt($request->input('password'));
        $user->save();
        return $user->id;
    }
}
