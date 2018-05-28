<?php

namespace App\Billing;

class WxPaymentGateway implements PaymentGateway
{
    public function prepay($data)
    {
    	return [
    		   "return_msg" => "OK",
    		   "openid" => "123",
    		   "result_code" => "SUCCESS",
    		   "prepay_id" => "wx201411102639507cbf6ffd8b0779950874",
    	];
    }

    public function handlePaidNotify($closure)
    {
        $result = call_user_func($closure, request()->all(), null);
        if ($result !== true) {
            return;
        }
        return response()->json(['return_code' => 'SUCCESS']);
    }
}
