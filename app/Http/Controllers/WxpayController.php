<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WithdrawController extends Controller
{
	protected $payment;

	public function __construct()
	{
		$this->payment = app('wechat.payment');
	}


    public function jsConfig()
    {
    	$prepayid = Order::prepayid();
    	$jssdk = $this->payment->jssdk;
    	$json = $jssdk->bridgeConfig($prepayid); // 返回 json 字符串，如果想返回数组，传第二个参数 false
        return $json;
    }
}
