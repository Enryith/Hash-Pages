<?php

namespace App\Repositories;

use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;
use LaravelDoctrine\ORM\Pagination\PaginatesFromRequest;

class Tags extends EntityRepository
{
	use PaginatesFromRequest;

	public function findAllLike($search, $limit = 10) {
		$search = $this->like($search);
		if (strlen($search) == 0) return [];

		$qb = $this->createQueryBuilder("t")
			->select("t.tag as display, t.id as id")
			->where("t.tag LIKE :tag")
			->setParameter("tag", "%$search%")
			->setMaxResults($limit);

		 return $qb->getQuery()->getArrayResult();
	}

	public static function like($search) {
		return preg_replace("/[%_]/", "", trim($search));
	}
}
