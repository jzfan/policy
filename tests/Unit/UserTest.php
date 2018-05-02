<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
	/** @test */
	public function create_user_if_not_exist()
	{
		$wechatUser = [
			'nickname' => 'Fake Wechat User',
			'id' => '1234',
			'avatar' => 'fake avatar'
		];
		$this->assertCount(0, User::all());
		$user = User::firstOrCreateBy($wechatUser);
		$this->assertCount(1, User::all());
		$this->assertEquals($user->name, 'Fake Wechat User');
		$this->assertEquals($user->openid, '1234');
		$this->assertEquals($user->avatar, 'fake avatar');
	}

	/** @test */
	public function fetch_user_if_exists()
	{
		$user = factory('App\User')->create(['openid' => 'abcd']);
		$wechatUser = [
			'nickname' => 'Fake Wechat User',
			'id' => $user->openid,
			'avatar' => 'fake avatar'
		];
		$this->assertCount(1, User::all());
		$user = User::firstOrCreateBy($wechatUser);
		$this->assertCount(1, User::all());
	}
}
