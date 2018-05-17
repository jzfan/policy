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
				'recommend' => [
						'blue' => [1, 2, 3],
						'red' => [4, 5, 6]
					],
			]);
	}

	/** @test */
	public function won_while_new_opencode_matches_any_recommend_blue_red()
	{
		$this->assertEquals('active', $this->policy->status);
		factory('App\Lottery')->create([
				'code' => 'ssq',
				'expect' => '2999001',
				'opencode' => '01,02,03,04,05,06+07'
			]);
		$this->policy = $this->policy->fresh();
		$this->assertEquals('won', $this->policy->status);
		$this->assertEquals($this->policy->win_number['red'], ['04', '05', '06']);
		$this->assertEquals($this->policy->win_number['blue'], []);
	}

	/** @test */
	public function lose_while_new_opencode_dont_matches_any_recommend_blue_red()
	{	
		$this->assertEquals('active', $this->policy->status);
		factory('App\Lottery')->create([
				'code' => 'ssq',
				'expect' => '2999001',
				'opencode' => '01,02,03,08,09,10+08'
			]);
		$this->policy = $this->policy->fresh();
		$this->assertEquals($this->policy->win_number['blue'], []);
		$this->assertEquals($this->policy->win_number['red'], []);
		$this->assertEquals('lose', $this->policy->status);
	}

}
