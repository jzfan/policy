<?php

namespace App\Fake;

class FakeLotteryApiGateway
{
	protected $faker;

	public function __construct()
	{
		$this->faker = \Faker\Factory::create();
		$this->hosts = ['host1', 'host2'];
	}

	public function fetchAll()
	{
		$arr = [];
		foreach ($this->hosts as $host) {
			$arr[$host][] = factory('App\Lottery')->raw(['code' => $host]);
		}
		return $arr;
	}
}