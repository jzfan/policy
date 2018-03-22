<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\FcApiGateway;

class FcLotteryApiTest extends TestCase
{
	use LotteryApiTestContract;

	public function setUp()
	{
		parent::setUp();
		$this->gateway = new FcApiGateway;
	}
}
