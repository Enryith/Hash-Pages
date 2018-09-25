<?php

namespace App\Repositories;

use App\Entities;
use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\PaginatesFromRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class User extends EntityRepository
{
	use PaginatesFromRequest;

	/**
	 * @return LengthAwarePaginator|Entities\User[]
	 */
	public function paginateUsers()
	{
		$query = $this->createQueryBuilder('o');

		return $this->paginate($query->getQuery(), 1, 'page');
	}
}
