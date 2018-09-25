<?php

namespace App\Repositories;

use Doctrine\Common\Persistence\ObjectRepository;

class User
{
	/**
	 * @var ObjectRepository
	 */
	private $users;

	public function __construct(ObjectRepository $users)
	{
		$this->users = $users;
	}
}
