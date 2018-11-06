<?php

namespace App\Repositories;

use App\Entities;
use App\Entities\User;
use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\PaginatesFromRequest;

class Chats extends EntityRepository
{
	use PaginatesFromRequest;

	public function paginateUserChats(User $user, $perPage = 20)
	{
		$query = $this->createQueryBuilder('c')
			->leftJoin("c.users", "u")
			->where("u = :user")
			->setParameter("user", $user)
			->select("c", "u")
			->getQuery();

		return $this->paginate($query, $perPage);
	}
}
