<?php

namespace App\Http\Controllers;

use App\Entities\User;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory as Validation;

class Settings extends Controller
{
	public function form()
	{
		return view('settings.form');
	}

	/**
	 * @param Request $request
	 * @param Validation $validator
	 * @param EntityManagerInterface $em
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function update(Request $request, Validation $validator, EntityManagerInterface $em)
	{
		/** @var User $user */
		$user = Auth::user();

		$valid = $validator->make($request->all(), [
			'picture' => "required|image"
		]);

		$valid->validate();

		//handle file upload

		//get filename with extension
		$filenameWithExt = $request->file('picture')->getClientOriginalName();

		//get just filename without extension
		$filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

		//get just extension without filename
		$extension = $request->file('picture')->getClientOriginalExtension();

		//make filename unique
		$filenameToStore =$filename.'_'.time().'.'.$extension;

		//store the file
		$path = $request->file('picture')->storeAs('public/profile_pictures', $filenameToStore);

		//store filename in database
		$user->setPicture($filenameToStore);

		$em->flush();

		return redirect('/settings');
	}

}