<?php

namespace Tests\Feature;

use App\PrepayRank;
use Tests\TestCase;
use App\FakePaymentGateway;

class WxpayNotifyTest extends TestCase
{
	/** @test */
	public function user_paid_suceess_get_tickets()
	{
		$this->app->instance('App\PaymentGateway', new FakePaymentGateway);
		$rank = PrepayRank::first();
		$user = factory('App\User')->create(['api_token' => '123']);
		$order = factory('App\Order')->create([
				"total_fee" => $rank->price,
				'user_id' => $user->id,
				'trade_no' => '20001010101'
			]);

		$this->post('/wxpay/notify', [
				"total_fee" => $rank->price,
				"api_token" => $user->api_token,
				"out_trade_no" => $order->trade_no,
				"result_code" => "SUCCESS",
				"time_end" => "20140903131540",
			])->assertStatus(200);
		$this->assertEquals('paid', $order->fresh()->status);
		$this->assertEquals($rank->tickets_qty, $user->fresh()->tickets_qty);
	}
}
