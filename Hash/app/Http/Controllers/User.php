<?php

namespace App\Http\Controllers;

use App\Entities;
use App\Repositories\Users;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory as Validation;
use Illuminate\Contracts\Auth\Guard;

class User extends Controller
{
	public function view(Request $request, Guard $auth, Users $users, $username = null)
	{
		$user = null;

		if ($username)
		{
			$user = $users->findOneByUsername($username);
		}
		else if ($auth->check())
		{
			$user = $auth->user();
		}
		else
		{
			$request->session()->flash("alert-danger", trans('auth.required'));
			return redirect("/auth/login");
		}

		if($user instanceof Entities\User)
		{
			return view('user.view')->with(compact('user'));
		}
		else
		{
			abort(404);
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

		$valid = $validator->make($request->all(), [
			'avatar' => "image|dimensions:max_width=800,max_height=800",
			'bio' => "max:300"
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

		$em->flush();

		return redirect('/user');
	}
}
