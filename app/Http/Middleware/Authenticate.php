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
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                $redirectTo = $request->getRequestUri();
                return redirect()->guest('/auth/login?redirectTo='.$redirectTo);
            }
        } else {
            $openid = session('openid');
            if(empty($openid)) {
                $profile = $this->weAuth->authorize($to = null, $scope = 'snsapi_userinfo', $state = 'STATE');
                $data = $profile->all();
                $user = $this->auth->user();
                try {
                    $alias = $user->aliases()->where('provider', 'wechat')->where('type', 'openid')->firstOrFail();
                    if($data['openid'] != $alias->alias) {
                        return response('Forbidden.', 403);
                    } else {
                        $alias->data = $profile->toJson();
                        $alias->save();
                    }
                    session('openid', $data['openid']);
                } catch(ModelNotFoundException $e) {
                    $user->aliases()->create([
                        'user_id' => $user->id,
                        'provider' => 'wechat',
                        'alias' => $data['openid'],
                        'type' => 'openid',
                        'data' => $profile->toJson()
                    ]);
                    session('openid', $data['openid']);
                }
            }
        }

        return $next($request);
    }
}
