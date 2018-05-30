<?php

namespace App\WechatMessageHandler;

use App\User;
use EasyWeChat\Kernel\Contracts\EventHandlerInterface;

class TextMessageHandler implements EventHandlerInterface
{
	protected $app;

	public function __construct($app)
	{
		$this->app = $app;
	}

	public function handle($payload = null)
	{
		// $user = $this->app->oauth->user();
		// $ss = request()->session()->all();
		// \Log::info($this->app->server->);
		return 'test';

	}
	
}