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
				'recommend' => [
						'bai' => [1, 2, 3],
						'shi' => [4, 5, 6],
						'ge' => [7, 8, 9]
				],
			]);
	}

	/** @test */
	public function won_while_new_opencode_in_recommend()
	{
		$this->assertEquals('active', $this->policy->status);

		factory('App\Lottery')->create([
				'code' => 'fc3d',
				'expect' => '2999001',
				'opencode' => '1,5,9',
			]);
		$this->assertEquals('won', $this->policy->fresh()->status);
		$win_number = $this->policy->fresh()->win_number;
		$this->assertEquals('1', $win_number['bai']);
		$this->assertEquals('5', $win_number['shi']);
		$this->assertEquals('9', $win_number['ge']);
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
