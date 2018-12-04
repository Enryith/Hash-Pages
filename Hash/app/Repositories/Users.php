<?php

namespace App\Repositories;

use App\Entities;
use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\PaginatesFromRequest;
use Laravel\Socialite\Contracts\User as Api;

class Users extends EntityRepository
{
	use PaginatesFromRequest;

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
	 * @return Entities\User|null
	 */
	public function findOneByUsername($username)
	{
		/** @var Entities\User $user */
		$user = $this->findOneBy([
			'username' => $username
		]);

		return $user;
	}

	/**
	 * @param $email
	 * @return Entities\User|null
	 */
	public function findOneByEmail($email)
	{
		/** @var Entities\User $user */
		$user = $this->findOneBy([
			'email' => $email
		]);

		return $user;
	}

	/**
	 * @param Api $api
	 * @param $endpoint
	 * @return Entities\User|null
	 */
	public function findOneByAPI(Api $api, $endpoint)
	{
		/** @var Entities\User $user */
		$user = $this->findOneBy([
			'endpoint' => $endpoint,
			'uuid' => $api->getId()
		]);

		return $user;
	}

	public function findOneById($id)
	{
		return $this->findOneBy(['id' => $id]);
	}
}
