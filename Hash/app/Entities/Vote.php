<?php

namespace App\Entities;

use App\Entities\Traits;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Vote
{
	use Traits\Id;

	const AGREE = 1;
	const DISAGREE = 0;

	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="votes")
	 * @var User
	 */
	private $user;

	/**
	 * @ORM\ManyToOne(targetEntity="Discussion", inversedBy="votes")
	 * @var Discussion
	 */
	private $discussion;

	/**
	 * @ORM\Column(type="integer")
	 * @var int
	 */
	private $type;

	public function __construct(User $user, Discussion $discussion)
	{
		$this->user = $user;
		$this->discussion = $discussion;
	}

	/**
	 * @return User
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * @param User $user
	 * @return Vote
	 */
	public function setUser(User $user)
	{
		$this->user = $user;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDiscussion()
	{
		return $this->discussion;
	}

	/**
	 * @param mixed $discussion
	 * @return Vote
	 */
	public function setDiscussion(Discussion $discussion)
	{
		$this->discussion = $discussion;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param int $type
	 * @return Vote
	 */
	public function setType($type)
	{
		$this->type = $type;
		return $this;
	}
}
