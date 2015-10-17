<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function getLogin(Request $request) {
        $type = $request->query('type', 'members');

        return view('mobile.login', compact('type'));
    }

    public function postLogin() {

    }

    public function getMembers() {
        return view('mobile.members');
    }

    public function getMembersReserve() {
        return view('mobile.members.reserve');
    }
}
