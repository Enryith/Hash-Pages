<?php

namespace App\Http\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Factory;
use App\Entities;


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
			'username' => 'required|unique:App\Entities\User,username|min:2|alpha_num',
			'name' => 'required',
			'email' => 'required|email',
			'password' => 'required|same:password_again|min:8',
			'password_again' => 'required',
		], [
			"min" => ':Attribute must be more than :min characters.',
			"required" => ':Attribute field is required.',
			"same" => ':Attribute must match :other',
			"alpha_num" => ':Attribute can only be letters and numbers.',
			"email" => 'The :attribute field does not look like an email.',
			"unique" => 'That :attribute is already used.',
		]);

		$valid->setAttributeNames([
			'password_again' => "the second password"
		]);

		$valid->validate();
		$data = $valid->getData();

		$hashWord =  password_hash($data["password"], PASSWORD_BCRYPT, ['cost' => 12]);

		$user = new Entities\User();
		$user->setUsername($data["username"])
			->setName($data["name"])
			->setEmail($data["email"])
			->setPassword($hashWord);

		$this->em->persist($user);
		$this->em->flush();

		return view('user.create', compact("user"));
	}
}
