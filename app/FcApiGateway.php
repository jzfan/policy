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

	public function fetchOne($host)
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
			$arr[] = self::fetchOne($host);
		}
		return $arr;
	}
	protected function format($row)
	{
		return [
			'code' => $row->code,
			'expect' => $row->data[0]->expect,
			'opencode' => $row->data[0]->opencode,
			'opentime' => $row->data[0]->opentime,
		];
	}
}