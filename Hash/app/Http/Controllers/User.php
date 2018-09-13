<?php

namespace App\Http\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Factory;
use App\Entities;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;


class User extends Controller
{
	protected $em;
	protected $validator;
	protected $flash;

	public function __construct(EntityManagerInterface $em, Factory $validator, FlashBag $flash)
	{
		$this->em = $em;
		$this->validator = $validator;
		$this->flash = $flash;
	}

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request) {

    }

	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function register(Request $request)
	{
		$valid = $this->validator->make($request->all(), [
			'username' => 'required|unique:App\Entities\User,username|min:2|alpha_num',
			'name' => 'required',
			'email' => 'required|email|unique:App\Entities\User,email',
			'password' => 'required|same:password_again|min:8',
			'password_again' => 'required',
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

		$this->flash->add("alert-success", "{$user->getName()}, your account has been created.");

		return view('user.login', compact("user"));
	}
}
