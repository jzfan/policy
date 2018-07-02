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
		return '
		a. 大数据智能预测
		通过历史大数据分析统计，智能预测下一期开奖号码（双色球，篮球，3D，3个号段
		b. 中奖率显著提高
		c. 您的彩票不中，我们给您买单
		通过红包券的使用激活，若您彩票点投注的号码没中，同时我们预测的号码也没中，则我们以红包的形式送给您2-66元现金';
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