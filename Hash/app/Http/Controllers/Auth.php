<?php
namespace App\Http\Controllers;

use App\Repositories\Users;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Factory as Validation;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Entities;

class Auth extends Controller
{
	use ThrottlesLogins;

	//Services
	protected $validator;
	protected $auth;

	//Defined from ThrottlesLogin
	protected $maxAttempts = 5;
	protected $decayMinutes = 2;

	//Constraints for password
	protected $constraintsPassword = "min:8|max:32";
	protected $constraintsUsername = "min:3|max:15";

	public function __construct(Validation $validator, Guard $auth)
	{
		/** @var StatefulGuard $auth */
		$this->validator = $validator;
		$this->auth = $auth;
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function welcome()
	{
		return view("main.landing");
	}

	/**
	 * Shows the login page. Uses Auth::auth when posted to.
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function login()
	{
		return view("user.login");
	}

	/**
	 * Shows the register form. Uses Auth::store when posted to.
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function register()
	{
		return view("user.register");
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function auth(Request $request)
	{
		//If we have failed too many times, don't even bother validating the user.
		if ($this->hasTooManyLoginAttempts($request))
		{
			$this->fireLockoutEvent($request);
			$this->sendLockoutResponse($request);
		}

		$valid = $this->validator->make($request->all(), [
			'login' => "required|{$this->constraintsUsername}",
			'password' => "required|{$this->constraintsPassword}",
		]);

		$valid->validate();

		//If the field looks like a username, attempt authentication with it.
		$field = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
		$request->merge([$field => $request->input('login')]);

		if ($this->auth->attempt($request->only($field, 'password'), $request->has('remember')))
		{
			/** @var Entities\User $user */
			$user = $this->auth->user();
			$this->clearLoginAttempts($request);
			$request->session()->flash("alert-success", trans('auth.success', ["name" => $user->getName()]));
			return redirect('/');
		}

		//We have failed login...
		//Login attempts comes from the ThrottlesLogin trait.
		$this->incrementLoginAttempts($request);
		$request->session()->flash("alert-danger", trans('auth.failed'));
		return redirect('/auth/login');
	}

	/**
	 * @param Request $request
	 * @param EntityManagerInterface $em
	 * @param Hasher $hash
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store(Request $request, EntityManagerInterface $em, Hasher $hash)
	{
		$valid = $this->validator->make($request->all(), [
			'username' => "required|unique:App\Entities\User,username|alpha_num|{$this->constraintsUsername}",
			'email' => 'required|email|unique:App\Entities\User,email',
			'name' => 'required|min:2',
			'password' => "required|same:password_confirmation|{$this->constraintsPassword}",
			'password_confirmation' => 'required',
		]);

		$valid->validate();
		$data = $valid->getData();

		$hashWord = $hash->make($data["password"], ['rounds' => 12]);
		$user = new Entities\User();
		$user->setUsername($data["username"])
			->setName($data["name"])
			->setEmail($data["email"])
			->setPassword($hashWord);

		$em->persist($user);
		$em->flush();
		$request->session()->flash("alert-success", trans('auth.created', ["name" => $user->getName()]));

		return redirect('/auth/login');
	}

	/**
	 * @param Request $request
	 * @param Session $session
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function logout(Request $request, Session $session)
	{
		$this->auth->logout();
		$session->flush();
		$request->session()->flash("alert-success", trans('auth.logout'));
		return redirect('/auth/login');
	}

	public function provider(Socialite $socialite, $provider)
	{
		return $socialite->driver($provider)->redirect();
	}

	public function endpoint(Users $users, Request $request, Socialite $socialite, EntityManagerInterface $em, $provider)
	{
		$api = null;

		try {
			$api = $socialite->driver($provider)->user();
		} catch (\Exception $e) {
			$request->session()->flash("alert-danger", "Something wen't wrong when contacting Google!");
			return redirect('/auth/login');
		}

		$user = $users->findOneByAPI($api, $provider);
		if ($user)
		{
			$this->auth->login($user, false);
			$request->session()->flash("alert-success", trans('auth.success', ["name" => $user->getName()]));
			return redirect('/');
		}

		//Make sure emails are unique
		$email = $users->findOneByEmail($api->getEmail());
		if ($email)
		{
			$request->session()->flash("alert-danger", "You already have an account using {$email->getEndpoint()}!");
			return redirect('/');
		}

		//Make sure user names are unique, but at least try to make something random if needed.
		$username = explode("@", $api->getEmail())[0];
		if ($users->findOneByUsername($username))
		{
			$username = substr($username, 0, 15) . rand(1000, 9999);

			if ($users->findOneByUsername($username))
			{
				$request->session()->flash("alert-danger", "Could not create username with Google Account information!");
				return redirect('/');
			}
		}

		$user = new Entities\User();
		$user->setName($api->getName())
			->setEmail($api->getEmail())
			->setPicture($api->getAvatar())
			->setUsername($username)
			->setEndpoint($provider)
			->setUuid($api->getId())
			->setPassword("no u");

		$em->persist($user);
		$em->flush();

		$this->auth->login($user, false);
		$request->session()->flash("alert-success", trans('auth.success', ["name" => $user->getName()]));
		return redirect('/');
	}

	//Required from the trait ThrottlesLogin, otherwise it crashes.
	public function username()
	{
		return "login";
	}
}
