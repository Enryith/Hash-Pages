<?php

namespace App\Repositories;

use Doctrine\ORM\EntityRepository;

class Tags extends EntityRepository
{
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

	private function like($search) {
		return preg_replace("/[%_]/", "", trim($search));
	}
}
