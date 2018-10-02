<?php

namespace App\Http\Controllers;


use App\Entities;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
	 * @param Request $request
	 * @param Validation $validator
	 * @param EntityManagerInterface $em
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Illuminate\Validation\ValidationException
	 * @throws \Exception
	 */
	public function update(Request $request, Validation $validator, EntityManagerInterface $em)
	{
		/** @var Entities\User $user */
		$user = Auth::user();

		$valid = $validator->make($request->all(), [
			'avatar' => "required|image|dimensions:max_width=800,max_height=800",
		]);

		$valid->validate();

		if ($user->getPicture())
		{
			Storage::delete($user->getPicture());
		}

		//store the file
		$id = $request->file('avatar')->storePublicly("public/avatars");

		//dd($id);

		//store filename in database
		$user->setPicture($id);

		$em->flush();

		return redirect('/user');
	}
}
