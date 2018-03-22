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
		$selected = rand(1, 16);
		$recommend = Policy::recommendForSsq($selected);
		$this->assertTrue(is_int(array_sum($recommend)));
		$this->assertNotContains($selected, $recommend);
	}

}
