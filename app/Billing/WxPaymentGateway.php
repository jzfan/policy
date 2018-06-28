<?php

namespace App\Billing;

use App\Order;
use App\Balance;

class WxPaymentGateway implements PaymentGateway
{
    protected $payment;

    public function __construct()
    {
        $this->payment = app('wechat.payment');
    }

    public function order($arr)
    {
    	$response = $this->payment->order->unify($arr);
        if ($this->isSuccess($response)) {
            Order::create([
                    'info' => $arr['body'],
                    'trade_no' => $arr['out_trade_no'],
                    'total_fee' => $arr['total_fee'],
                    'user_id' => auth()->id(),
                    'status' => 'ordered'
                ]);
            return $this->payment->jssdk->bridgeConfig($response['prepay_id']);
        }
        abort(500, 'wxpay unify order failed');
    }

    public function isPaid($trade_no)
    {
        $response = $this->payment->order->queryByOutTradeNumber($trade_no);
        // \Log::info(json_encode($response));
        if (isset($response['trade_state']) && $response['trade_state'] === 'SUCCESS') {
                return true;
            }
        return false;
    }

    public function handlePaidNotify($closure)
    {
        // $result = call_user_func($closure, request()->all(), null);
        // if ($result !== true) {
        //     return;
        // }
        // return response()->json(['return_code' => 'SUCCESS']);
    }

    public function withdraw()
    {
        return \DB::transaction(function() {
            $authUser = \DB::table('users')->where('id', auth()->id())->lockForUpdate()->first();
            if ($authUser->account < 100) {
                return '提现金额必须大于1块钱';
            }

            $partnerTradeNo = date('ymdHis') . $authUser->id;
            $response = $this->payment->transfer->toBalance([
                'partner_trade_no' => $partnerTradeNo, // 商户订单号，需保持唯一性(只能是字母或者数字，不能包含有符号)
                'openid' => $authUser->openid,
                'check_name' => 'NO_CHECK', // NO_CHECK：不校验真实姓名, FORCE_CHECK：强校验真实姓名
                // 're_user_name' => '王小帅', // 如果 check_name 设置为FORCE_CHECK，则必填用户真实姓名
                'amount' => $authUser->account, // 企业付款金额，单位为分
                'desc' => "彩保提现", // 企业付款操作说明信息。必填
            ]);

            if ($this->isSuccess($response) || $this->isSuccess($this->payment->transfer->queryBalanceOrder($partnerTradeNo), 'status')) {
                return $this->withdrawSuccess();
            } 
            return $response['err_code_des'];
        });
    }

    protected function withdrawSuccess()
    {
        Balance::create([
                'user_id' => auth()->id(),
                'type' => '提现',
                'amount' => auth()->user()->account
            ]);
        auth()->user()->update(['account' => 0]);
        return 'success';
    }

    protected function isSuccess($response, $key='result_code')
    {
        return isset($response[$key]) && $response[$key] == 'SUCCESS';
    }
}
