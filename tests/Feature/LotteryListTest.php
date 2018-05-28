<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LotteryListTest extends TestCase
{
	/** @test */
	public function ssq_group_by_win_number()
	{
		factory('App\Lottery', 2)->create(['code' => 'ssq', 'opencode'=> '0,0,0+01']);
		factory('App\Lottery', 3)->create(['code' => 'ssq', 'opencode'=> '0,0,0+12']);
		$this->get('/api/lotteries/count?code=ssq&limit=100')
			->assertStatus(200)
			->assertJsonFragment(['number' => 1, 'count' => 2])
			->assertJsonFragment(['number' => 12, 'count' => 3]);
	}

	/** @test */
	public function fc3d_group_count_by_win_number()
	{
		factory('App\Lottery')->create(['code' => 'fc3d', 'opencode'=> '1,2,3']);
		factory('App\Lottery')->create(['code' => 'fc3d', 'opencode'=> '3,2,1']);
		$res = $this->get('/api/lotteries/count?code=fc3d&limit=100')
			->assertStatus(200)
			->assertJsonStructure(['bai', 'shi', 'ge'])
			->decodeResponseJson();
		$this->assertContains(['number' => 1, 'count' => 1], $res['bai']);
		$this->assertContains(['number' => 3, 'count' => 1], $res['bai']);
		$this->assertContains(['number' => 2, 'count' => 2], $res['shi']);
		$this->assertContains(['number' => 3, 'count' => 1], $res['ge']);
		$this->assertContains(['number' => 1, 'count' => 1], $res['ge']);
			// ->dump();
	}
}
