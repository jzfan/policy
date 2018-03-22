<?php

namespace App\Http\Controllers;

use App\Order;
use App\PrepayRank;
use App\PaymentGateway;
use Illuminate\Http\Request;

class OrderController extends Controller
{
	public function wxNotify()
	{
		$payment = \EasyWeChat::payment();
		$response = $payment->handlePaidNotify(function($message, $fail){
		    $order = Order::where('trade_no', $message['out_trade_no']);
		    if (!$order || $order->status != 'ordered') { // 如果订单不存在 或者 订单已经支付过了
		        return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
		    }
		    ///////////// <- 建议在这里调用微信的【订单查询】接口查一下该笔订单的情况，确认是已经支付 /////////////

	        // 用户是否支付成功
	        if (array_get($message, 'result_code') === 'SUCCESS') {
	            $order->update(['status' => 'paid']);
	        } 
		    return true; // 返回处理完成
		});

		return $response;
	}
}
