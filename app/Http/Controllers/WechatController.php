<?php
/**
 * Created by PhpStorm.
 * User: yechunan
 * Date: 15/8/21
 * Time: 00:27
 */

namespace App\Http\Controllers;

use Overtrue\Wechat\Server;
use Overtrue\Wechat\Auth;
use Overtrue\Wechat\Js;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WechatController extends Controller {

    /**
     * 处理微信的请求消息
     *
     * @param \Overtrue\Wechat\Server $server
     *
     * @return string
     */
    public function serve(Server $server)
    {
        $server->on('message', function($message){
            return "欢迎关注 [锐思达健身]，微信公众号建设中，敬请期待！";
        });

        return $server->serve(); // 或者 return $server;
    }

    //微信回调地址 /wechat/callback
    public function callback(Request $request, Guard $auth, Auth $wxAuth) {
        $redirectTo = $request->query('redirectTo', '/');
        $profile = $wxAuth->user();
        $data = $profile->all();
        $user = $auth->user();
        try {
            $alias = $user->aliases()->where('provider', 'wechat')->where('type', 'openid')->firstOrFail();
            if($data['openid'] != $alias->alias) {
                return response('Forbidden.', 403);
            } else {
                $alias->data = $profile->toJson();
                $alias->save();
            }
        } catch(ModelNotFoundException $e) {
            $user->aliases()->create([
                'user_id' => $user->id,
                'provider' => 'wechat',
                'alias' => $data['openid'],
                'type' => 'openid',
                'data' => $profile->toJson()
            ]);
        }
        $request->session()->put('openid', $data['openid']);
        return redirect($redirectTo);
    }
}
