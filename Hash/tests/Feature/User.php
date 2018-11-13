<?php

namespace Tests\Feature;

use Tests\Base;
use Illuminate\Foundation\Testing\RefreshDatabase;

class User extends Base
{
	public function setUp()
	{
		parent::setUp();
		$this->startSession()
			->json('POST', '/register', [
				'username' => 'bob33',
				'email' => 'test@test.test',
				'name' => 'bob',
				'password' => '0731andrew',
				'password_confirmation' => '0731andrew'
			]);

		$this->startSession()
			->json('POST', '/auth/login', [
				'login' => 'bob33',
				'password' => '0731andrew'
			]);
	}

	public function testPost()
	{
		$response = $this->startSession()
			->json('POST', '/post', [
				'title' => 'Chicken dinner!!!',
				'link' => '',
				'body' => 'eat some chicken',
				'tag' => 'salad',
			]);
		$response->dump();
	}
}
