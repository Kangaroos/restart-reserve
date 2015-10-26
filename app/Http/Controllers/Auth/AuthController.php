<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use Kodeine\Acl\Models\Eloquent\Role;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    protected $username = 'mobile';

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function getLogin(Request $request) {
        $type = $request->query('type', 'members');
        $redirectTo = $request->query('redirectTo', '/');
        return view('mobile.login', compact('type', 'redirectTo'));
    }

    public function postLogin(Request $request) {

        $type = $request->query('type', 'members');

        $rules = [
            'name' => 'required|max:255',
            'mobile' => 'required|mobile|mobile_changed',
            'verifyCode' => 'required|min:4|verify_code|verify_rule:check_mobile',
        ];

        if($type == 'members') {
            $rules['card_number'] = 'required';
        }

        try {
            $this->validate($request,$rules);
        } catch(HttpResponseException $e) {
            throw $e;
        } finally {
            $request->session()->forget(config('laravel-sms.sessionKey'));
        }

        $mobile = $request->input('mobile');
        $name = $request->input('name');
        $card_number = $request->input('card_number');

        $response = array('success' => true, 'jwt-token' => '', 'redirectTo' => $request->input('redirectTo', '/'));

        try {
            $user = User::where('mobile', $mobile)->firstOrFail();

            $token = JWTAuth::fromUser($user);

            $request->session()->put('jwt-token',$token);

            $response['jwt-token'] = $token;

            Auth::login($user);
        } catch(ModelNotFoundException $e) {
            $values = [
                'name' => $name,
                'mobile' => $mobile
            ];

            if($type == 'members') {
                $values['card_number'] = $card_number;
                $values['status'] = 'inactive';
            }

            $user = User::create($values);

            $roleMember = Role::where('name', 'Member')->first();

            $user->assignRole($roleMember);

            $token = JWTAuth::fromUser($user);

            $request->session()->put('jwt-token',$token);

            $response['jwt-token'] = $token;

            Auth::login($user);
        }

        return response()->json($response);
    }

    public function getLogout() {
        Auth::logout();
        return redirect('/auth/login');
    }
}
