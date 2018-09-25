<?php

namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Score
{
	use Traits\Id;

	/**
	 * @ORM\ManyToOne(targetEntity="Tag", inversedBy="scores")
	 * @var Tag
	 */
	private $tag;

	/**
	 * @ORM\ManyToOne(targetEntity="Post", inversedBy="scores")
	 * @var Post
	 */
	private $post;

	/**
	 * @ORM\ManyToOne(targetEntity="Discussion", inversedBy="scores")
	 * @var Discussion
	 */
	private $discussion;

	/**
	 * @ORM\Column(type="integer")
	 * @var integer
	 */
	private $contributes;

	/**
	 * @ORM\Column(type="integer")
	 * @var integer
	 */
	private $spam;
}
