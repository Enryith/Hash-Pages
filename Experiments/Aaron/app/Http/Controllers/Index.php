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
		return view('welcome');
	}
}
