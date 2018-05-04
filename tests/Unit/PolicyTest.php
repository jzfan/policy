<?php

namespace Tests\Unit;

use App\Policy;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PolicyTest extends TestCase
{
	/** @test */
	public function can_get_recommend_for_shuangSeQiu()
	{
		// $selected = '07';
		foreach (range(1, 16) as $n) {
			$selected = str_pad($n, 2, '0', STR_PAD_LEFT);
			$recommend = Policy::recommendForSsq($selected);
			$this->assertTrue(is_int(array_sum($recommend)));
			$this->assertNotContains($selected, $recommend);
		}
	}
}
