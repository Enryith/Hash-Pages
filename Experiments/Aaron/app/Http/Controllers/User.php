<?php

namespace App\Http\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Factory;


class User extends Controller
{
	protected $em;
	protected $validator;

	public function __construct(EntityManagerInterface $em, Factory $validator)
	{
		$this->em = $em;
		$this->validator = $validator;
	}

	public function register()
	{
		return view('user.register');
	}

	/**
	 * @param Request $request
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store(Request $request)
	{
		$this->validator->validate($request->all(), [
			'username' => 'required|unique:App\Entities\User,username',
			'password' => 'required|same:password_again',
			'password_again' => 'required',
		]);
	}
}
