<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QrcodeTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->recommender = factory('App\User')->create();
	}

	/** @test */
	public function recommender_get_points_after_new_user_subscribed_by_scan_his_qrcode()
	{
		$this->post('wechat', ['MsgType' => 'event']);
			// ->dump();
		// $this->post('/api/qrcodes', [], $this->authHeader)
		// 	->assertStatus(201);
	}
}
