<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->user = factory('App\User')->create();
		$this->authHeader = ['Authorization' => "Bearer {$this->user->api_token}"];
	}

	/** @test */
	public function account_increase_while_user_take_hongbao()
	{
		$this->assertEquals(0, $this->user->account);

		$policy = factory('App\Policy')->create([
				'user_id' => $this->user->id,
				'status' => 'lose'
			]);
		$this->put('/api/accounts', ['type' => 'increment', 'policy_id' => $policy->id], $this->authHeader)
			->assertStatus(200);
		$this->assertEquals(200, $this->user->fresh()->account);
		$this->assertEquals('rewarded', $policy->fresh()->status);
	}

	/**
	@test
	@expectedException Symfony\Component\HttpKernel\Exception\HttpException 
	*/
	public function account_not_increase_if_the_user_id_wrong()
	{
		$this->assertEquals(0, $this->user->account);

		$policy = factory('App\Policy')->create([
				// 'user_id' => $this->user->id,
				'status' => 'lose'
			]);
		$this->put('/api/accounts', ['type' => 'increment', 'policy_id' => $policy->id], $this->authHeader)
			->assertStatus(400);
	}

	/**
	@test
	@expectedException Symfony\Component\HttpKernel\Exception\HttpException 
	*/
	public function account_not_increase_if_the_status_is_not_lose()
	{
		$this->assertEquals(0, $this->user->account);

		$policy = factory('App\Policy')->create([
				'user_id' => $this->user->id,
				'status' => 'not_lose'
			]);
		$this->put('/api/accounts', ['type' => 'increment', 'policy_id' => $policy->id], $this->authHeader)
			->assertStatus(400);
	}
}
