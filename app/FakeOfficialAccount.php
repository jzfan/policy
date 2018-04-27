<?php

namespace App;

class FakeOfficialAccount
{
	public $oauth;

	public function __construct()
	{
		$this->oauth = new FakeOauth;
	}

}