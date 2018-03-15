<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Resources\PolicyResource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PolicyTest extends TestCase
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
		$rand = rand(1, 16);
		$data = [
			'type' => 'shuang_se_qiu',
			'number' => $rand,
			'period' => '2018001'
		];
		$response = $this->post("/api/policies", $data, $this->authHeader)->assertStatus(201)->getContent();
		$response = json_decode($response)->data;
		$this->assertEquals($rand, $response->number);
		$this->assertTrue(ctype_digit($response->recommended_number));
	}

	/** @test */
	public function auth_user_can_input_sanD_number_to_get_recomended_number()
	{
		$rand = rand(1, 16);
		$data = [
			'type' => 'san_d',
			'number' => $rand,
			'period' => '2018001'
		];
		$response = $this->post("/api/policies", $data, $this->authHeader)->assertStatus(201)->getContent();
		// $response = json_decode($response)->data;
		// $this->assertEquals($rand, $response->number);
		// $this->assertTrue(is_int($response->recomended_section->min));
		// $this->assertTrue(is_int($response->recomended_section->max));
		// $arr = [$response->recomended_section->min, $rand, $response->recomended_section->max];
		// sort($arr);
		// dd($arr);
		// $this->assertTrue( $rand == $sorted[0] or $rand == $sorted[2]);
	}
}
