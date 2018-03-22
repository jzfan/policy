<?php

namespace Tests\Feature;

use App\Lottery;
use Tests\TestCase;

trait LotteryApiTestContract
{

	/** @test */
	public function can_get_lottery_data()
	{
		$data = $this->gateway->fetchAll();
		$this->assertEquals(count($this->gateway->hosts), count($data));
		foreach ($data as $row) {
			$this->assertArrayHasKey('code', $row);
			$this->assertArrayHasKey('expect', $row);
			$this->assertArrayHasKey('opencode', $row);
			$this->assertArrayHasKey('opentime', $row);
		}
	}
}
