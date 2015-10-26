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
}
