<?php
namespace App\Http\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Factory as Validation;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Entities;

class Auth extends Controller
{
	use ThrottlesLogins;

	//Services
	protected $em;
	protected $validator;
	protected $auth;
	protected $hash;

	//Defined from ThrottlesLogin
	protected $maxAttempts = 5;
	protected $decayMinutes = 2;

	//Constraints for password
	protected $constraintsPassword = "min:8|max:32";
	protected $constraintsUsername = "min:3|alpha_num";

	public function __construct(EntityManagerInterface $em, Validation $validator, Guard $auth, Hasher $hash)
	{
		/** @var StatefulGuard $auth */
		$this->em = $em;
		$this->validator = $validator;
		$this->auth = $auth;
		$this->hash = $hash;
	}

	/**
	 * TODO: Temporary test route.
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
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store(Request $request)
	{
		$valid = $this->validator->make($request->all(), [
			'username' => "required|unique:App\Entities\User,username|{$this->constraintsUsername}",
			'email' => 'required|email|unique:App\Entities\User,email',
			'name' => 'required|min:2',
			'password' => "required|same:password_confirmation|{$this->constraintsPassword}",
			'password_confirmation' => 'required',
		]);

		$valid->validate();
		$data = $valid->getData();

		$hashWord = $this->hash->make($data["password"], ['rounds' => 12]);
		$user = new Entities\User();
		$user->setUsername($data["username"])
			->setName($data["name"])
			->setEmail($data["email"])
			->setPassword($hashWord);

		$this->em->persist($user);
		$this->em->flush();
		$request->session()->flash("alert-success", trans('auth.created', ["name" => $user->getName()]));

		return redirect('/auth/login');
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function logout(Request $request)
	{
		$this->auth->logout();
		$request->session()->flash("alert-success", trans('auth.logout'));
		return redirect('/auth/login');
	}

	//Required from the trait ThrottlesLogin, otherwise it crashes.
	public function username()
	{
		return "login";
	}

}
