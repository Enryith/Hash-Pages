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

	const AGREE = "agree";
	const DISAGREE = "disagree";

	//list of valid types, their KEY will be stored.
	const TYPES = [
		0 => self::DISAGREE,
		1 => self::AGREE,
	];

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
		$this->type = $this->setType(self::AGREE);
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
	 * @return string
	 */
	public function getType()
	{
		return self::TYPES[$this->type];
	}

	/**
	 * @param string $type
	 * @return Vote
	 */
	public function setType($type)
	{
		$this->type = array_search($type, self::TYPES);

		//Remember, array_search(...) can return false AND 0
		if ($this->type === false)
		{
			throw new \InvalidArgumentException("Undefined type!");
		}

		return $this;
	}

	public static function isValid($type)
	{
		return !(array_search($type, self::TYPES) === false);
	}
}
