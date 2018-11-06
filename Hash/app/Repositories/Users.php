<?php

namespace App\Repositories;

use App\Entities;
use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\PaginatesFromRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class Users extends EntityRepository
{

	public function findAllLike($search, $limit = 10) {
		$search = Tags::like($search);
		if (strlen($search) == 0) return [];

		$qb = $this->createQueryBuilder("u")
			->select("CONCAT(u.username, ' (', u.name, ')') as display, u.id as id")
			->where("u.username LIKE :user")
			->orWhere("u.name LIKE :user")
			->setParameter("user", "%$search%")
			->setMaxResults($limit);

		return $qb->getQuery()->getArrayResult();
	}

	/**
	 * @param $username
	 * @return Entities\User|null|object
	 */
	public function findOneByUsername($username)
	{
		return $this->findOneBy(['username' => $username]);
	}
}
