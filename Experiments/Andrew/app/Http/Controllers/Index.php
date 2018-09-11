<?php

namespace App\Http\Controllers;

use App\Entities\User;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Routing\Controller as BaseController;

class Index extends BaseController
{
	protected $em;

	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}

	public function index()
	{
		/** @var User $user */
		$user = $this->em->find("App\Entities\User", 2);
		var_dump($user->getName());
		return view('welcome', ['user' => $user]);
	}
}
