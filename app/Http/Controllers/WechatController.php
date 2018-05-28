<?php

namespace App\Http\Controllers;

// use App\WechatMessageHandler\EventMessageHandler;

class WechatController extends Controller
{
     public function serve()
    {
        $app = app('wechat.official_account');
        // $app->server->push(EventMessageHandler::class, Message::EVENT);
        $app->server->push(function($message){
            return "欢迎关注 overtrue！";
        });
        return $app->server->serve();
    }
}
