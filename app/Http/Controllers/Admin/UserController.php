<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;

class UserController extends Controller
{
    public function index(Request $request) {
        // 获取排序条件
        $orderColumn = $request->get('sort_up', $request->get('sort_down', 'created_at'));
        $direction   = $request->get('sort_up') ? 'asc' : 'desc' ;

        $users = User::whereHas('roles', function ($query) {
            $query->where('slug', 'member');
        })->orderBy($orderColumn, $direction)->paginate(999);

        return view('admin.user.list', compact('users', 'query'));
    }
}
