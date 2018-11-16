<?php

namespace App\Repositories;

use App\Entities;
use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\PaginatesFromRequest;

class Comments extends EntityRepository
{
	use PaginatesFromRequest;

	/**
	 * @param $id
	 * @return Entities\Comment|null|object
	 */
	public function findOneById($id)
	{
		return $this->findOneBy(['id' => $id]);
	}
}
