<?php

namespace App\Http\Middleware;

use Overtrue\Wechat\Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Authenticate
{
    protected $auth;
    protected $weAuth;

    public function __construct(Guard $auth, Auth $weAuth)
    {
        $this->auth = $auth;
        $this->weAuth = $weAuth;
    }

    public function handle($request, Closure $next)
    {
        $redirectTo = $request->getRequestUri();

        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('/auth/login?redirectTo='.$redirectTo);
            }
        } else {
//            $openid = $request->session()->get('openid');
//            if(empty($openid)) {
//                $this->weAuth->redirect($to = route('wechat.callback').'?redirectTo='.urlencode($redirectTo), $scope = 'snsapi_userinfo', $state = 'STATE');
//            }
        }

        return $next($request);
    }
}
