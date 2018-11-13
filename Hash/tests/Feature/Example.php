<?php

namespace Tests\Feature;

use Tests\Base;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Example extends Base
{
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testBasicTest()
	{
		$response = $this->get('/');
		$response->assertStatus(200);
	}

	public function testRegisterPage()
	{
		$response = $this->get('/register');
		$response->assertStatus(200);
	}
}
