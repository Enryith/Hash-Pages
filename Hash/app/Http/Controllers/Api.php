<?php

namespace App\Http\Controllers;

use App\Repositories\Tags;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class Api extends Controller
{
	function test() {
		return ["success" => "It Works!"];
	}

	function tags(Request $request, Tags $tags) {
		return $tags->findAllLike($request->get("q"));
	}
}
