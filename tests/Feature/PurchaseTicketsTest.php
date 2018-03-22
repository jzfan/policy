<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\FakePaymentGateway;

class PurchaseTicketsTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		$payment = new FakePaymentGateway;
		$this->app->instance('App\PaymentGateway', $payment);
		$this->user = factory('App\User')->create();
		$this->authHeader = ['Authorization' => "Bearer {$this->user->api_token}"];
	}

	/** @test */
	public function user_can_order_tickets()
	{
		$this->assertCount(0, $this->user->orders);

		$this->post('/api/tickets', ['rank' => 1], $this->authHeader)
			 ->assertStatus(201);
		$this->assertCount(1, $this->user->fresh()->orders);
	}
}
