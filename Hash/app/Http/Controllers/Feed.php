<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class Feed extends Controller
{
	public function feed()
	{
		return view('feed.feed');
	}
}
