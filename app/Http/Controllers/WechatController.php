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

class WechatController extends Controller {

    /**
     * 处理微信的请求消息
     *
     * @param Overtrue\Wechat\Server $server
     *
     * @return string
     */
    public function serve(Server $server)
    {
        $server->on('message', function($message){
            return "欢迎关注 overtrue！";
        });

        return $server->serve(); // 或者 return $server;
    }

    public function demo(Auth $auth)
    {
        // $auth 则为容器中 Overtrue\Wechat\Auth 的实例



    }
}
