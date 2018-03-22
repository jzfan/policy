<?php

namespace App;

class FakePaymentGateway implements PaymentGateway
{
    public function charge($data)
    {
    	return [
    		   "return_msg" => "OK",
    		   "openid" => "123",
    		   "result_code" => "SUCCESS",
    		   "prepay_id" => "wx201411102639507cbf6ffd8b0779950874",
    	];
    }

    public function notify()
    {
    	return [
    		   "total_fee" => "100",
    		   "openid" => "123",
    		   "out_trade_no" => "1409811653",
    		   "result_code" => "SUCCESS",
    		   "time_end" => "20140903131540",
    	];
    }
}
