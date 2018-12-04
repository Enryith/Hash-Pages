<?php
namespace App\Http\Controllers;


use App\Repositories\Posts;
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

	public function view(Guard $auth, Posts $posts, Tags $tags, $tagname)
	{
		$tag = $tags->findOneBy(["tag" => $tagname]);

		$query = $posts->createQueryBuilder("p")
			->leftJoin("p.discussions", "d")
			->leftJoin("d.tag", "t")
			->select("p", "d", "t")
			->where("t = :tag")
			->setParameter(":tag", $tag)
			->orderBy('p.recentActivity', "DESC");

		$table = $tags->paginate($query->getQuery(), 20);

		return view('tag.view')->with(compact('table', 'tag'));
	}

}