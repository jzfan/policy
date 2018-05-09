<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LotteryListTest extends TestCase
{
	/** @test */
	// public function list_group_by_code()
	// {
	// 	$lotteries = factory('App\Lottery', 10)->create(['code' => 'test']);
	// 	$res = $this->get('/api/lotteries?code=test')
	// 		->assertStatus(200)
	// 		->decodeResponseJson();
	// 	$this->assertCount(10, $res);
	// }

	/** @test */
	public function ssq_group_by_win_number()
	{
		factory('App\Lottery', 2)->create(['code' => 'ssq', 'opencode'=> '0,0,0+01']);
		factory('App\Lottery', 3)->create(['code' => 'ssq', 'opencode'=> '0,0,0+12']);
		$this->get('/api/lotteries/count?code=ssq')
			->assertStatus(200)
			->dump();
	}
}
