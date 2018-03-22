<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WxpayNotifyTest extends TestCase
{
	/** @test */
	public function user_paid_suceess_get_tickets()
	{
		$user = factory('App\User')->create();
		$order = factory('App\Order')->create([
				'user_id' => $user->id
			]);
		$this->post('/wxpay/notify', [
				"total_fee" => "100",
				"openid" => "123",
				"out_trade_no" => "1409811653",
				"result_code" => "SUCCESS",
				"time_end" => "20140903131540",
			])
			 ->assertStatus(200);
	}
}
