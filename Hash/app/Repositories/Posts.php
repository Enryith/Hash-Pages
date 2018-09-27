<?php

namespace App\Repositories;

use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\PaginatesFromRequest;

class Posts extends EntityRepository
{
	use PaginatesFromRequest;
}
