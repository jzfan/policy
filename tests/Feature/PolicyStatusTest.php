<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PolicyStatusTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->lottery = factory('App\Lottery')->create([
				'code' => 'test_code',
				'expect' => '2002001',
			]);
		$this->policy = factory('App\Policy')->create([
				'code' => 'test_code',
				'expect' => '2999001',
				'status' => 'active',
				'recommend' => [2],
			]);

	}

	/** @test */
	public function won_while_new_opencode_tail_in_recommend()
	{
		$this->assertEquals('active', $this->policy->status);

		$this->lottery->update([
				'expect' => '2999001',
				'opencode' => '0,0,0,2'
			]);
		$this->assertEquals('won', $this->policy->fresh()->status);
	}

	/** @test */
	public function lose_while_new_opencode_tail_not_in_recommend()
	{	
		$this->assertEquals('active', $this->policy->status);

		$this->lottery->update([
				'expect' => '2999001',
				'opencode' => '0,0,0,1'
			]);
		$this->assertEquals('lose', $this->policy->fresh()->status);
	}
}
