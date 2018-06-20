<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SignTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->user = factory('App\User')->create(['points' => 0]);
		$this->authHeader = ['Authorization' => "Bearer {$this->user->api_token}"];
		// [18, 28, 58, 158, 28, 28, 268]
	}

	/** @test */
	public function can_get_points()
	{
		$this->get('/api/sign', $this->authHeader);
		$this->assertEquals(1, $this->user->fresh()->sign_continuly);
		$this->assertEquals(18, $this->user->fresh()->points);
	}

	/** @test */
	public function is_a_loop()
	{
		$this->user->update(['sign_at' => \Carbon\Carbon::yesterday(), 'sign_continuly' => 7]);
		$this->get('/api/sign', $this->authHeader);
		$this->assertEquals(1, $this->user->fresh()->sign_continuly);
		$this->assertEquals(18, $this->user->fresh()->points);
	}
}
