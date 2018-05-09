<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Fc3dPolicyStatusTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->policy = factory('App\Policy')->create([
				'code' => 'fc3d',
				'expect' => '2999001',
				'status' => 'active',
				'recommend' => ['002', '003'],
			]);
	}

	/** @test */
	public function won_while_new_opencode_in_recommend()
	{
		$this->assertEquals('active', $this->policy->status);

		factory('App\Lottery')->create([
				'code' => 'fc3d',
				'expect' => '2999001',
				'opencode' => '0,0,2',
			]);
		$this->assertEquals('won', $this->policy->fresh()->status);
		$this->assertEquals('002', $this->policy->fresh()->win_number);
	}

	/** @test */
	public function lose_while_new_opencode_tail_not_in_recommend()
	{	
		$this->assertEquals('active', $this->policy->status);

		factory('App\Lottery')->create([
				'code' => 'fc3d',
				'expect' => '2999001',
				'opencode' => '0,0,1'
			]);
		$this->assertEquals('lose', $this->policy->fresh()->status);
	}
}
