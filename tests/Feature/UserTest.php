<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->user = factory('App\User')->create(['points' => 100, 'tickets_qty'=>0]);
		$this->authHeader = ['Authorization' => "Bearer {$this->user->api_token}"];
	}

	/** @test */
	public function can_find_user_by_code()
	{
		$this->get('/api/oauth/user?code=iloveyou')
			 ->assertJsonStructure([
			 	'api_token', 'name', 'avatar'
			 ]);
	}

	/** @test */
	public function can_get_one_ticket_by_100_points()
	{
		$this->assertEquals(100, $this->user->points);
		$this->assertEquals(0, $this->user->tickets_qty);

		$this->get('/api/tickets/bypoints', $this->authHeader);
		$this->assertEquals(0, $this->user->fresh()->points);
		$this->assertEquals(1, $this->user->fresh()->tickets_qty);
	}
}
