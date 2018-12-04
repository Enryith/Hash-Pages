<?php

namespace App\Http\Controllers;


use App\Repositories\Users;
use Doctrine\ORM\EntityManager;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Routing\Controller;

class Admin extends Controller
{
	/**
	 * @param Users $users
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Users $users)
	{
		$query = $users->createQueryBuilder("u")
			->select("u");

		$table = $users->paginate($query->getQuery(), 20);
		return view('admin.index')->with(compact('table'));
	}

	public function addAdmin(User $user, Gate $gate, EntityManager $em){
		if($gate->denies('admin', $user))
			return abort(403);

		$em->flush();
		return view('admin.index');
	}

	public function addView(User $user, Gate $gate){
		if($gate->allows('admin', $user))
			return view('admin.addView');
		else
			return abort(403);
	}
}