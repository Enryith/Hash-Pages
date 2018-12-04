<?php

namespace App\Http\Controllers;

use App\Entities;
use App\Repositories\Posts;
use App\Repositories\Users;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory as Validation;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Validation\Rule;

class User extends Controller
{
	public function self(Posts $posts, Guard $auth) {
		/** @var Entities\User $user */
		$user = $auth->user();
		return $this->velf($posts, $user);
	}

	public function view(Users $users, Posts $posts, $username)
	{
		$user = $users->findOneByUsername($username);

		return $this->velf($posts, $user);
	}

	public function velf(Posts $posts, Entities\User $user)
	{


		if($user instanceof Entities\User)
		{
			$query = $posts->createQueryBuilder("p")
				->where("p.author = :user")
				->setParameter(":user", $user)
				->orderBy('p.id', "DESC");

			$table = $posts->paginate($query->getQuery(), 20);

			return view('user.view')->with(compact('table','user'));
		}
		else
		{
			abort(404);
			return redirect("/");
		}
	}

	public function form(Guard $auth)
	{
		/** @var Entities\User $user */
		$user = $auth->user();
		return view('user.form')->with(compact('user'));
	}

	/**
	 * @param Guard $auth
	 * @param Request $request
	 * @param Validation $validator
	 * @param EntityManagerInterface $em
	 * @param Filesystem $file
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function update(Guard $auth, Request $request, Validation $validator, EntityManagerInterface $em, Filesystem $file)
	{
		/** @var Entities\User $user */
		$user = $auth->user();

		$options = implode(",", array_keys(Entities\User::themeOptions()));
		$valid = $validator->make($request->all(), [
			'avatar' => "image|dimensions:max_width=800,max_height=800",
			'bio' => "max:300",
			'username' => "required|unique:App\Entities\User,username,{$user->getId()}|alpha_num|min:3|max:15",
			'theme' => "required|in:$options",
		]);

		$valid->validate();
		$data = $valid->getData();

		if($request->exists("avatar")) {
			if ($user->getPicture()) {
				$file->delete($user->getPicture());
			}

			$user->setPicture($request->file('avatar')->storePublicly("public/avatars"));
		}

		$user->setBio($data['bio']);
		$user->setTheme($data['theme']);
		$user->setUsername($data['username']);

		$em->flush();

		return redirect('/user');
	}
}
