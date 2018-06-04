<?php

namespace App\Http\Controllers;

use App\Order;
use App\PrepayRank;
use App\Billing\PaymentGateway;
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

    public function byPoints()
    {
        auth()->user()->lockForUpdate();
        $points = auth()->user()->points;
        $tickets_qty = auth()->user()->tickets_qty;
        if ($points >= 200) {
            auth()->user()->update(['points' => $points-200, 'tickets_qty' => $tickets_qty+1]);
        }
        return auth()->user();
    }

    public function byRank()
    {
        auth()->user()->lockForUpdate();
        $rank_remain = auth()->user()->rank_remain;
        $tickets_qty = auth()->user()->tickets_qty;
        if ($rank_remain >= 1) {
            auth()->user()->update(['rank_remain' => $rank_remain-1, 'tickets_qty' => $tickets_qty+10]);
        }
        return auth()->user();
    }
}
