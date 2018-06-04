<?php

namespace App\Http\Controllers;

use EasyWeChat\Kernel\Messages\Message;
use App\WechatMessageHandler\TextMessageHandler;
use App\WechatMessageHandler\EventMessageHandler;

class WechatController extends Controller
{
	protected $server;
	protected $menu;

	public function __construct()
	{
		$app = app('wechat.official_account');
		$this->menu = $app->menu;
		$this->server = $app->server;
	}

     public function serve()
    {
        $this->createMenu();
        $this->server->push(EventMessageHandler::class, Message::EVENT);
        $this->server->push(TextMessageHandler::class, Message::TEXT);
        return $this->server->serve();
    }

    protected function createMenu()
    {
        \Cache::remember('buttons', 10, function() {
            if (app()->environment() !== 'testing') {
                $this->menu->create(config('menu'));
            }
        });
    }
}
