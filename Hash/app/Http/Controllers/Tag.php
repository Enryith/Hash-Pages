<?php
namespace App\Http\Controllers;


use App\Repositories\Tags;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Routing\Controller;

class Tag extends Controller
{
	public function index(Tags $tags, Guard $auth)
	{
		$query = $tags->createQueryBuilder("p")
			->orderBy("p.tag", "ASC");

		$table = $tags->paginate($query->getQuery(), 20);
		return view("tag.index")->with(compact('table'));
	}

	public function view(Guard $auth, Tags $tags, $tagname)
	{
		$tag = $tags->findOneBy(["tag" => $tagname]);

		return view('tag.view')->with(compact('tag'));
	}

}