<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\FakePaymentGateway;

class WxpayNotifyTest extends TestCase
{
	/** @test */
	public function user_paid_suceess_get_tickets()
	{
		$this->app->instance('App\PaymentGateway', new FakePaymentGateway);
		$user = factory('App\User')->create(['api_token' => '123']);
		$order = factory('App\Order')->create([
				"total_fee" => "1000",
				'user_id' => $user->id,
				'trade_no' => '20001010101'
			]);
		$this->post('/wxpay/notify', [
				"total_fee" => "1000",
				"api_token" => "123",
				"out_trade_no" => "20001010101",
				"result_code" => "SUCCESS",
				"time_end" => "20140903131540",
			])->assertStatus(200);
		$this->assertEquals('paid', $order->fresh()->status);
		$this->assertEquals(10, $user->fresh()->ticket);
	}
}
