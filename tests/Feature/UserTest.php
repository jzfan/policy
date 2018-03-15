<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
	/** @test */
	public function a_weixin_user_can_register()
	{
		$wx_user = [
			"openid" =>"oLn0awp7W5-J6qEeamsACqC9BCeE",
			"nickname" => "Fan",
			"sex" =>"1",
			"province" =>"湖北",
			"city" =>"武汉",
			"country" =>"中国",
			"headimgurl" => "http://wx.qlogo.cn/mmopen/hNWCQ9bibbzF5eDhERZwwSEn31DicnqoouJgX7vZeZfDeV4H57gcldGPdJ3VgrqAHgR6cSmLurvq949vfJpdDrlA2jicUkLdCHB/0",
		];
		$this->post('/api/register', $wx_user)
			 ->assertJsonFragment([
			 		'name' => 'Fan', 
			 		'api_token' => 'oLn0awp7W5-J6qEeamsACqC9BCeE'
			 	]);
	}
}
