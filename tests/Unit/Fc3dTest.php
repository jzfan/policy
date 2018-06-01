<?php

namespace Tests\Unit;

use App\Fc3d;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Fc3dTest extends TestCase
{
	/** @test */
	public function testAllNull()
	{
		$arr = [
			'bai' => null,
			'shi' => null,
			'ge' => null
		];
		$status = (new Fc3d('0,0,0'))->allNull($arr);
		$this->assertTrue($status);
	}
}
