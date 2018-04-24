<?php

namespace App\Http\Controllers;

use App\Order;
use App\PrepayRank;
use App\PaymentGateway;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected $payment;

    public function __construct(PaymentGateway $payment)
    {
        $this->payment = $payment;
    }

    public function prepay()
    {
        $rank = PrepayRank::find(request('rank'));
        $trade_no = date('YmdHis' . str_pad( auth()->id(), 3, '0', STR_PAD_LEFT));
        $res = $this->payment->prepay([
            'body' => '会员充值',
            'out_trade_no' => $trade_no,
            'total_fee' => $rank->price,
            'trade_type' => 'JSAPI',
            'openid' => auth()->user()->api_token,
            'notify_url' => '/wxpay/notify'
        ]);
        if ($res["result_code"] != "SUCCESS") {
        	return response()->json($res['return_msg'], 500);
        }
        $order = Order::create([
            'info' => '会员充值',
            'trade_no' => $trade_no,
            'total_fee' => $rank->price,
            'user_id' => auth()->id(),
            'status' => 'ordered'
        ]);
    	return response()->json('success', 201);
    }
}
