<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SsqPolicyStatusTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->policy = factory('App\Policy')->create([
				'code' => 'ssq',
				'expect' => '2999001',
				'status' => 'active',
				'recommend' => ['02'],
			]);
	}

	/** @test */
	public function won_while_new_opencode_tail_in_recommend()
	{
		$this->assertEquals('active', $this->policy->status);

		factory('App\Lottery')->create([
				'code' => 'ssq',
				'expect' => '2999001',
				'opencode' => '0,0,0+02'
			]);
		$this->assertEquals('won', $this->policy->fresh()->status);
	}

	/** @test */
	public function lose_while_new_opencode_tail_not_in_recommend()
	{	
		$this->assertEquals('active', $this->policy->status);

		factory('App\Lottery')->create([
				'code' => 'ssq',
				'expect' => '2999001',
				'opencode' => '0,0,0+01'
			]);
		$this->assertEquals('lose', $this->policy->fresh()->status);
	}
}
