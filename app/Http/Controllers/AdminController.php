<?php

namespace App\Http\Controllers;

class AdminController extends Controller {

    public function getIndex()
    {
        return view('admin.index');
    }

    public function getLogin() {
        return view('admin-login');
    }
}
