<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
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

	public function getTag() {
		return $this->tag;
	}

	public function __construct($tag, $post){
		$this->setTag($tag);
		$this->setPost($post);
		$this->discussion = null;
		$this->contributes = 0;
		$this->spam = 0;
	}

	public function setPost(Post $post)
	{
		$post->addScore($this);
		$this->post = $post;
		return $this;
	}

	public function setTag(Tag $tag){
		$tag->addScore($this);
		$this->tag = $tag;
		return $this;
	}
}
