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
	 * @ORM\ManyToOne(targetEntity="Discussion", inversedBy="comments")
	 * @var Discussion
	 */
	private $discussion;

	/**
	 * @ORM\ManyToOne(targetEntity="Comment", inversedBy="children")
	 * @var Comment
	 */
	private $parent;

	/**
	 * @ORM\OneToMany(targetEntity="Comment", mappedBy ="parent")
	 * @var ArrayCollection|Comment[]
	 */
	private $children;

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
