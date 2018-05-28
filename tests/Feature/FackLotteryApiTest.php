<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Fake\FakeLotteryApiGateway;

class FackLotteryApiTest extends TestCase
{
	use LotteryApiTestContract;

	public function setUp()
	{
		parent::setUp();
		$this->gateway = new FakeLotteryApiGateway;
	}

}
