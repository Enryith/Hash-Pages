<?php

namespace Tests\Feature;

use Tests\Base;

class Route extends Base
{
	public function testHomePage()
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
