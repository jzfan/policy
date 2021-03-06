<?php

namespace App\Http\Controllers;

use App\Order;
use App\Billing\PaymentGateway;
use Illuminate\Http\Request;

class OrderController extends Controller
{
	protected $payment;

	public function __construct(PaymentGateway $payment)
	{
		$this->payment = $payment;
	}

	public function unify()
	{
		$data = request()->validate([
				'n' => 'required|numeric'
			]);
		return  $this->payment->order([
				'body' => '会员充值',
				'out_trade_no' => date('ymdHis') . auth()->id(),
				'total_fee' => $data['n'] * 100,
				'trade_type' => 'JSAPI',
				'openid' => auth()->user()->openid
			]);
	}

	public function check()
	{
		$data = request()->validate([
				'n' => 'required|numeric'
			]);
		if ($data['n'] == 1 && auth()->user()->rank != 1) {
			abort(400, 'only for rank 1');
		}
		foreach (auth()->user()->orders()->ordered()->get() as $order) {
			$this->payment->isPaid($order->trade_no) ? $order->active($data['n']) : $order->delete();
		}
	}

	public function wxNotify()
	{
		\Log::info('----------notify-------------');
		// $response = $this->payment->handlePaidNotify(function ($message, $fail) {
		// 	\Log::info(json_encode($message));
		// 	$order = Order::where(['trade_no' => $message['out_trade_no']])->first();
		// 	if (!$order || $order->paid_at) {
		// 	    return true;
		// 	}
		// 	///////////// <- 建议在这里调用微信的【订单查询】接口查一下该笔订单的情况，确认是已经支付 /////////////

		//     // 用户是否支付成功
		//     if (array_get($message, 'result_code') === 'SUCCESS') {
		//     	$order->paid_at = time();
		//         $order->status = 'paid';
		//         PrepayRank::sold($order);
		//     // 用户支付失败
		//     } elseif (array_get($message, 'result_code') === 'FAIL') {
		//         $order->status = 'paid_fail';
		//     }
		// 	$order->save(); // 保存订单

		// 	return true; // 返回处理完成
		// });

		// return $response;
	}
}
