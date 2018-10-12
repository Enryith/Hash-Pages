<?php
namespace App\Http\Controllers;

use App\Repositories\Posts;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Factory as Validation;
use App\Entities;

class Post extends Controller
{
	public function index(Posts $posts)
	{
		$table = $posts->paginateAll(2);
		return view('post.index')->with(compact('table'));
	}

	public function form()
	{
		return view('post.form');
	}

	/**
	 * @param Request $request
	 * @param EntityManagerInterface $em
	 * @param Validation $validator
	 * @param Guard $auth
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store(Request $request, EntityManagerInterface $em, Validation $validator, Guard $auth)
	{
		$valid = $validator->make($request->all(), [
			'title' => "required|min:2",
			'link' => 'required|min:13',
			'body' => 'required|min:10',
		]);

		$valid->validate();
		$data = $valid->getData();

		/** @var $user Entities\User */
		$user = $auth->user();
		$post = new Entities\Post($user, $data["title"], $data["link"], $data["body"]);
		$em->persist($post);
		$em->flush();
		return redirect('/all');
	}

	public function view(Posts $posts, $id = null)
	{
		$post = $posts->findOneById($id);

		if($post instanceof Entities\Post)
		{
			return view('post.view')->with(compact('post'));
		}
		else
		{
			abort(404);
		}
	}
}
