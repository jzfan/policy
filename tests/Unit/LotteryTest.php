<?php

namespace Tests\Unit;

use App\Lottery;
use Tests\TestCase;

class LotteryTest extends TestCase
{
	/** @test */
	public function it_can_calc_next_expect()
	{
		$next = Lottery::calcNextExpect(date('Y').'123');
		$this->assertEquals($next, date('Y').'124');

		$next = Lottery::calcNextExpect('2010123');
		$this->assertEquals($next, date('Y').'001');

	}

	/** @test */
	public function only_create_new_open()
	{
		$lottery = factory('App\Lottery')->create();
		$data = [
				'code' => $lottery->code,
				'expect' => $lottery->expect,
				'opencode' => '0,0,0,0',
				'opentime' => $lottery->opentime,
		];
		Lottery::createIfNewOpen($data);
		$this->assertCount(1, Lottery::where('code', $lottery->code)->get());

		$data['expect'] = '2999001';
		Lottery::createIfNewOpen($data);

		$this->assertCount(2, Lottery::where('code', $lottery->code)->get());
	}

	/** @test */
	public function can_check_user_rank_for_view_limit()
	{
		$user = factory('App\User')->create(['rank' => 1]);
		$this->be($user);
		$this->assertTrue(Lottery::checkUserRankForLimit(50, 'select'));
		$this->assertFalse(Lottery::checkUserRankForLimit(100, 'select'));
		$this->assertFalse(Lottery::checkUserRankForLimit(200, 'select'));
		$user->update(['rank' => 12]);
		$this->assertTrue(Lottery::checkUserRankForLimit(50, 'select'));
		$this->assertTrue(Lottery::checkUserRankForLimit(100, 'select'));
		$this->assertFalse(Lottery::checkUserRankForLimit(200, 'select'));
		$user->update(['rank' => 20]);
		$this->assertTrue(Lottery::checkUserRankForLimit(50, 'select'));
		$this->assertTrue(Lottery::checkUserRankForLimit(100, 'select'));
		$this->assertTrue(Lottery::checkUserRankForLimit(200, 'select'));
		$this->assertFalse(Lottery::checkUserRankForLimit(201, 'select'));
		$user->update(['rank' => 50]);
		$this->assertTrue(Lottery::checkUserRankForLimit(50, 'select'));
		$this->assertTrue(Lottery::checkUserRankForLimit(100, 'select'));
		$this->assertTrue(Lottery::checkUserRankForLimit(200, 'select'));
		$this->assertTrue(Lottery::checkUserRankForLimit(888, 'select'));
	}

}
