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
	public function it_can_get_tail_of_opencode()
	{
		$lottery = factory('App\Lottery')->make(['opencode' => '1,2,3']);
		$this->assertEquals(3, $lottery->tail());
		$lottery = factory('App\Lottery')->make(['opencode' => '13,14,20,21,25,33+07']);
		$this->assertEquals(7, $lottery->tail());
	}

	/** @test */
	public function only_update_new_open()
	{
		$lottery = factory('App\Lottery')->create();
		$data = [
				'code' => $lottery->code,
				'expect' => $lottery->expect,
				'opencode' => '0,0,0,0',
				'opentime' => $lottery->opentime,
		];
		Lottery::updateIfNewOpen($data);
		$this->assertNotEquals('0,0,0,0', $lottery->fresh()->opencode);

		$data['expect'] = '2999001';
		Lottery::updateIfNewOpen($data);

		$this->assertEquals('2999001', $lottery->fresh()->expect);
		$this->assertEquals('0,0,0,0', $lottery->fresh()->opencode);
	}
}
