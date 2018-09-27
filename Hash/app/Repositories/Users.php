<?php

namespace App\Repositories;

use App\Entities;
use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\PaginatesFromRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class Users extends EntityRepository
{
	use PaginatesFromRequest;

	/**
	 * @return LengthAwarePaginator|Entities\User[]
	 */
	public function paginateUsers()
	{
		$query = $this->createQueryBuilder('u');
		return $this->paginate($query->getQuery(), 1, 'page');
	}
}
