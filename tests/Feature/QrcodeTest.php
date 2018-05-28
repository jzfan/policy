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
		$this->user = factory('App\User')->create();
		$this->authHeader = ['Authorization' => "Bearer {$this->user->api_token}"];
	}

	/** @test */
	public function recommender_get_one_ticket_after_new_user_subscribed_by_scan_his_qrcode()
	{
		// $this->post('/api/qrcodes', [], $this->authHeader)
		// 	->assertStatus(201);
	}
}
