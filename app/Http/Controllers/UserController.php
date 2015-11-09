<?php

namespace App\Http\Controllers;

use App\Reserve;
use Illuminate\Http\Request;
use App\Http\Requests;

class UserController extends Controller
{
    public function getMembers() {
        return view('mobile.members');
    }

    public function getMembersReserve(Request $request) {
        $user = $request->user();
        $reserves = $user->reserves;
        return view('mobile.members.reserve', compact('reserves'));
    }

    public function getMembersReserveDetail(Request $request, $id) {
        $reserve = Reserve::find($id);
        return view('mobile.members.reserve-detail', compact('reserve'));
    }
}
