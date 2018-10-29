<?php
namespace App\Http\Controllers;

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
	public function index(Posts $posts)
	{
		$table = $posts->paginateAll(20);
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
		$valid = $validator->make($request->all(), [
			'title' => "required|min:2",
			'body' => "required|min:10",
			'link' => "sometimes|nullable|url",
			'tags' => "required",
		]);

		$valid->validate();
		$data = $valid->getData();
		$ids = array_unique(explode(",", $data["tags"]), SORT_STRING);

		/** @var $user Entities\User */
		$user = $auth->user();
		$post = new Entities\Post($user, $data["title"], trim($data["link"]), $data["body"]);

		foreach ($ids as $id)
		{
			//Find one by will be null if it does not exist
			$tag = $tags->findOneBy(["id" => $id]);

			if (!$tag)
			{
				//If the tag does not exists, stop and throw an exception
				throw ValidationException::withMessages([
					'tags' => [trans("validation.exists")],
				]);
			}

			$score = new Entities\Score($tag, $post);
			$em->persist($score);
		}

		$em->persist($post);
		$em->flush();

		//Send user to the post they just created
		return redirect("/post/{$post->getId()}");
	}

	public function view(Posts $posts, $id)
	{
		$post = $posts->findOneById($id);

		if($post instanceof Entities\Post)
		{
			return view('post.view')->with(compact('post'));
		}

		return abort(404);
	}
}
