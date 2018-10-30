<?php
namespace App\Http\Controllers;

use App\Events;
use App\Repositories\Posts;
use App\Repositories\Tags;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Factory as Validation;
use App\Entities;
use Illuminate\Validation\ValidationException;

class Post extends Controller
{
	/**
	 * @param Posts $posts
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Posts $posts)
	{
		$table = $posts->paginate($posts->createQueryBuilder("p")
			->leftJoin("p.discussions", "d")
			->leftJoin("d.tag", "t")
			->select("p,d,t")
			->getQuery(),
			20);
		return view('post.index')->with(compact('table'));
	}

	public function form()
	{
		return view('post.form');
	}

	/**
	 * @param Tags $tags
	 * @param Request $request
	 * @param EntityManagerInterface $em
	 * @param Validation $validator
	 * @param Guard $auth
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store(Tags $tags, Request $request, EntityManagerInterface $em, Validation $validator, Guard $auth)
	{
		/** @var $user Entities\User */
		$user = $auth->user();
		$valid = $validator->make($request->all(), [
			'title' => "required|min:2",
			'body' => "required|min:10",
			'link' => "sometimes|nullable|url",
			'tag' => "required|max:20|alpha_num",
		]);

		$valid->validate();
		$data = $valid->getData();

		//Find one by will be null if it does not exist
		$tag = $tags->findOneBy(["tag" => $data["tag"]]);
		if (!$tag)
		{
			//Create tag for the user if it does not exist.
			$tag = new Entities\Tag($data["tag"]);
			$em->persist($tag);
		}

		//Create post and initial discussion with tag
		$post = new Entities\Post($user, $data["title"], trim($data["link"]), $data["body"]);

		event(new Events\Post($post));

		$discussion = new Entities\Discussion($post, $tag, $user, "Original Post");
		$em->persist($discussion);
		$em->persist($post);
		$em->flush();

		//Send user to the post they just created
		return redirect("/post/{$post->getId()}");
	}

	/**
	 * @param Posts $posts
	 * @param $id
	 * @return \Illuminate\View\View
	 * @throws \Doctrine\ORM\NonUniqueResultException
	 */
	public function view(Posts $posts, $id)
	{
		$post = $posts->createQueryBuilder("p")
			->leftJoin("p.discussions", "d")
			->leftJoin("d.tag", "t")
			->select("p, d, t")
			->where("p = :p")
			->setParameter("p", $id)
			->getQuery()
			->getOneOrNullResult();

		if($post instanceof Entities\Post)
		{
			return view('post.view')->with(compact('post'));
		}

		return abort(404);
	}
}
