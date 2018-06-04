<?php

namespace App\WechatMessageHandler;

use App\User;
use EasyWeChat\Kernel\Contracts\EventHandlerInterface;

class EventMessageHandler implements EventHandlerInterface
{
	protected $event;
	protected $eventKey;
	protected $fromUserOpenid;

	public function __construct($app)
	{
		$message = $app->server->getMessage();
		// \Log::info(json_encode($message));
		$this->event = $message['Event'];
		$this->fromUserOpenid = $message['FromUserName'];
		$this->eventKey = $message['EventKey'];
	}

	public function handle($payload = null)
	{
		if ($this->isNewSubscribeFromQrcode()) {
			User::givePoints($this->getQrcodeUserId());
		}
		return '欢迎关注 !';
	}

	private function isNewSubscribeFromQrcode()
	{
		return $this->event === 'subscribe' && $this->eventKey !== null && User::where('openid', $this->fromUserOpenid)->count() === 0;
	}

	private function getQrcodeUserId()
	{
		return str_replace('qrscene_', '', $this->eventKey);
	}
	
}