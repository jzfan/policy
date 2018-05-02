<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadPolicyTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->user = factory('App\User')->create();
		$this->authHeader = ['Authorization' => "Bearer {$this->user->api_token}"];
	}

	/** @test */
	public function auth_user_can_get_list_of_used_policies()
	{
		factory('App\Policy')->create(['user_id' => $this->user->id, 'status' => 'active']);
		factory('App\Policy')->create(['user_id' => $this->user->id, 'status' => 'won']);
		factory('App\Policy')->create(['user_id' => $this->user->id, 'status' => 'lose']);
		$this->get("/api/policies", $this->authHeader)->assertStatus(200);
		$this->assertCount(3, $this->user->policies);
	}
}
