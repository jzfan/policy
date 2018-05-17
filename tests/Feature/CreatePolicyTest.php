<?php

namespace Tests\Feature;

use App\Policy;
use Tests\TestCase;
use App\Http\Resources\PolicyResource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePolicyTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->user = factory('App\User')->create();
		$this->authHeader = ['Authorization' => "Bearer {$this->user->api_token}"];
	}

	/** @test */
	public function auth_user_can_input_shuangSeQiu_number_to_get_recomended_number()
	{
		$selected = rand(1, 16);
		$data = [
			'code' => 'ssq',
			'number' => $selected,
		];
		$res = $this->post("/api/policies", $data, $this->authHeader)
			 ->assertStatus(201)
			->decodeResponseJson();
		$this->assertEquals($selected, $res['number']);
		// dd($res['recommend']);
		foreach ($res['recommend']['blue'] as $n) {
			$this->assertTrue(is_int($n));
			$this->assertNotEquals($selected, $n);
			$this->assertLessThanOrEqual(16, $selected);
			$this->assertGreaterThanOrEqual(1, $selected);
		}
		foreach ($res['recommend']['red'] as $red) {
			$this->assertTrue(is_int($red));
			$this->assertGreaterThanOrEqual(1, $red);
			$this->assertLessThanOrEqual(33, $red);
		}
		// $this->assertCount(config('setting.ssq_odds'), $res['recommend']);
	}

	/** @test */
	public function auth_user_can_input_sanD_number_to_get_recommended_number()
	{
		$selected = rand(0, 999);
		$data = [
			'code' => 'fc3d',
			'number' => $selected,
		];
		$res = $this->post("/api/policies", $data, $this->authHeader)
					->assertStatus(201)
					->decodeResponseJson();

		$this->assertEquals($selected, $res['number']);
		$strSelected = str_pad($selected, 3, '0', STR_PAD_LEFT);
		// dd($res);
		$index = 0;
		foreach ($res['recommend'] as $group) {
			$this->checkGroupExcept($group, $strSelected[$index]);
			$index++;
		}
		// $this->assertCount(config('setting.fc3d_odds'), $res['recommend']);
	}

	protected function checkGroupExcept($group, $except)
	{
		$this->assertCount(3, $group);
		foreach ($group as $n) {
			$this->assertTrue(is_int($n));
			$this->assertNotEquals($except, $n);
			$this->assertLessThanOrEqual(9, $n);
			$this->assertGreaterThanOrEqual(0, $n);
		}
	}
}
