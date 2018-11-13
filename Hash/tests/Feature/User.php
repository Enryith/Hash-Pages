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
			->followingRedirects()
			->json('POST', '/post', [
				'title' => 'Chicken Dinner!!!',
				'link' => '',
				'body' => 'eat some chicken',
				'tag' => 'salad',
			]);
		$response->assertSee('Chicken Dinner!!!');
		$response->assertSee('@bob33');

		$response = $this->startSession()
			->json('POST', '/ajax/vote', [
				'discussion' => '1',
				'type' => 'agree',
			]);
		$response->assertJson(['votes'=>["agree"=>1,"disagree"=>0]]);
	}

	public function testUpdateUser()
	{
		$response = $this->startSession()
			->followingRedirects()
			->json('POST', '/settings', [
				'username' => 'ahhhhhhhhhhhhhhhhhhhhhh',
				'bio' => 'eat some chicken',
				'theme' => 'sandstone',
			]);
		$response->assertJsonValidationErrors(['username']);
	}

}
