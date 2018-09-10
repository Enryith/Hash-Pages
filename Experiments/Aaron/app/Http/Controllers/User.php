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
		$valid = $this->validator->make($request->all(), [
			'username' => 'required|unique:App\Entities\User,username|min:2',
			'password' => 'required|same:password_again|min:8',
			'password_again' => 'required',
		], [
			"min" => ':Attribute must be more than :min characters.',
			"required" => ':Attribute field is required.',
			"same" => ':Attribute must match :other',
		]);

		$valid->setAttributeNames([
			'password_again' => "the second password"
		]);

		$valid->validate();
	}
}
