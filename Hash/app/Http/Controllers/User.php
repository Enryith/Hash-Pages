<?php

namespace App\Http\Controllers;

use App\Entities;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory as Validation;
use Illuminate\Contracts\Auth\Guard;

class User extends Controller
{
	public function view(Guard $auth, EntityManagerInterface $em, $user = null)
	{
		if ($user) {
			dd($user);
		} else if ($auth->check()) {
			$user = $auth->user();

			return view('user.view')->with(compact('user'));
		} else {
			dd('Not authenticated, no user.');
		}
	}

	public function form()
	{
		return view('user.form');
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
			'avatar' => "required|image|dimensions:max_width=800,max_height=800",
		]);

		$valid->validate();

		if ($user->getPicture())
		{
			$file->delete($user->getPicture());
		}

		$user->setPicture($request->file('avatar')->storePublicly("public/avatars"));
		$em->flush();

		return redirect('/user');
	}
}
