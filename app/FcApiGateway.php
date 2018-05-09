<?php

namespace App;

use GuzzleHttp\Client;

class FcApiGateway
{
	public function __construct()
	{
		$this->faker = \Faker\Factory::create();
		$this->hosts = collect(config('api.fc'));
		$this->client = new Client;
	}

	public function fetchGroupByCode($host)
	{
		$res = $this->client->get($host)->getBody()->getContents();
		$res = json_decode($res);
		if (is_null($res)) {
			throw new \Exception('fc api error', 503);
		}
		return $this->format($res);
	}

	public function fetchAll()
	{
		$arr = [];
		foreach ($this->hosts as $host) {
			$arr[] = self::fetchGroupByCode($host);
		}
		return $arr;
	}
	protected function format($row)
	{
		$arr = [];
		foreach ($row->data as $one) {
			$arr[] = [
				'code' => $row->code,
				'expect' => $one->expect,
				'opencode' => $one->opencode,
				'opentime' => $one->opentime,
			];
		}
		return $arr;
	}
}