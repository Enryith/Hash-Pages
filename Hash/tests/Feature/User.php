<?php

namespace Tests\Feature;

use Tests\Base;

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
			])
			->assertRedirect('/');
	}

	public function tearDown()
	{
		$this->startSession()
			->get('/auth/logout')
			->assertRedirect("/auth/login");

		parent::tearDown();
	}

	public function testPost()
	{
		$this->startSession()
			->followingRedirects()
			->json('POST', '/post', [
				'title' => 'Chicken Dinner!!!',
				'link' => '',
				'body' => 'eat some chicken',
				'tag' => 'salad',
			])
			->assertSee('Chicken Dinner!!!')
			->assertSee('@bob33');

		$this->startSession()
			->json('POST', '/ajax/vote', [
				'discussion' => '1',
				'type' => 'agree',
			])
			->assertJson(['votes'=>["agree"=>1,"disagree"=>0]]);

		$this->startSession()
			->json('POST', '/comment/1/root', [
				'reply'=>'Your post is bad.'
			]);

		$this->get('/post/1/view')
			->assertSee('Your post is bad.');
	}

	public function testUpdateUser()
	{
		$this->startSession()
			->followingRedirects()
			->json('POST', '/settings', [
				'username' => 'ahhhhhhhhhhhhhhhhhhhhhh',
				'bio' => 'eat some chicken',
				'theme' => 'sandstone',
			])
			->assertJsonValidationErrors(['username']);
	}

}
