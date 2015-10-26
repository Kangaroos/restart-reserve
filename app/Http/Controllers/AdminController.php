<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller {

    public function getIndex(Request $request)
    {
        return view('admin.index');
    }

    public function getLogin(Request $request) {
        $redirectTo = $request->query('redirectTo', '/admin');
        return view('admin-login', compact('redirectTo'));
    }

    public function postLogin(Request $request) {
        $this->validate($request, [
            'mobile' => 'required', 'password' => 'required',
        ]);

        $credentials = $request->only('mobile', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/admin');
        }

        return redirect()
            ->back()
            ->withInput();
    }

    public function getLogout(Request $request) {
        Auth::logout();
        return redirect('/admin/login');
    }
}
