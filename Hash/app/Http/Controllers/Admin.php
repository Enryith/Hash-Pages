<?php

namespace App\Http\Controllers;


use App\Repositories\Users;
use App\Entities\User;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Cache\Repository;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Factory as Validation;
use Illuminate\Validation\ValidationException;

class Admin extends Controller
{
	/**
	 * @param Users $users
	 * @param User $user
	 * @param Gate $gate
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Users $users, User $user, Gate $gate)
	{
		if($gate->denies('admin', $user))
			return abort(403);

		$query = $users->createQueryBuilder("u")
			->where("u.admin = 1");

		$table = $users->paginate($query->getQuery(), 20);
		return view('admin.index')->with(compact('table'));
	}

	/**
	 * @param Users $users
	 * @param Gate $gate
	 * @param Request $request
	 * @param EntityManagerInterface $em
	 * @param Validation $validator
	 * @param Guard $auth
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws ValidationException
	 */
	public function addAdmin(Users $users, Gate $gate, Request $request, EntityManagerInterface $em, Validation $validator, Guard $auth){

		$user = $auth->user();
		if($gate->denies('admin', $user))
			return abort(403);

		$valid = $validator->make($request->all(),[
			'user' => "required|exists:App\Entities\User,username"
		]);
		$valid->validate();
		$data = $valid->getData();

		$aUser = $users->findOneByUsername($data["user"]);
		$aUser->setAdmin(true);

		$em->persist($aUser);
		$em->flush();
		return redirect("/admin");
	}

	/**
	 * @param Users $users
	 * @param Gate $gate
	 * @param Request $request
	 * @param EntityManagerInterface $em
	 * @param Guard $auth
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function removeAdmin(Users $users, Gate $gate, Request $request, EntityManagerInterface $em, Guard $auth, $id){

		$user = $auth->user();
		if($gate->denies('admin', $user))
			return abort(403);

		$remUser = $users->findOneById($id);
		if('Remove' == $request->get('submit')){
			$remUser->setAdmin(false);
			$em->persist($remUser);
			$em->flush();
		}
		return redirect("/admin");
	}

	public function remove(Gate $gate, Guard $auth)
	{
		$user = $auth->user();
		if($gate->denies('admin', $user))
			return abort(403);
		else
			return view('admin.delete');
	}
}

