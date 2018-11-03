<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Comment
{
	use Traits\Id;

	/**
	 * @ORM\OneToOne(targetEntity="Discussion", inversedBy="comment")
	 * @var Discussion
	 */
	private $discussion;

	/**
	 * @ORM\ManyToOne(targetEntity="Comment", inversedBy="child")
	 * @var Comment
	 */
	private $parent;

	/**
	 * @ORM\OneToMany(targetEntity="Comment", mappedBy ="parent")
	 * @var ArrayCollection|Comment[]
	 */
	private $child;

	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="comment")
	 * @var ArrayCollection|User[]
	 */
	private $author;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $comment;
}
