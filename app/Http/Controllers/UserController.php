<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class UserController extends Controller
{
    public function getMembers() {
        return view('mobile.members');
    }

    public function getMembersReserve() {
        return view('mobile.members.reserve');
    }
}
