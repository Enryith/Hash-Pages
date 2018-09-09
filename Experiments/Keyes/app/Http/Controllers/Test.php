<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class Test extends BaseController
{
	public function test()
	{
		/** @var String[] $person */
		$person = [
			'name' => 'keyes',
			'age' => '19',
		];

		return view('test', compact('person'));
	}
}