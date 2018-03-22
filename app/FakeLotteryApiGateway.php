<?php

namespace App;

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
			$arr[] = factory('App\Lottery')->raw();
		}
		return $arr;
	}
}