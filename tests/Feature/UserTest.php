<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
	/** @test */
	public function can_find_user_by_code()
	{
		$this->get('/api/oauth/user?code=iloveyou')
			 ->assertJsonStructure([
			 	'api_token', 'name', 'avatar'
			 ]);
	}
}
