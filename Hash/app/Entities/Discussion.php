<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Discussion
{
	use Traits\Id;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $title;

	/**
	 * @ORM\ManyToOne(targetEntity="Post", inversedBy="discussions")
	 * @var Post
	 */
	private $post;

	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="leading")
	 * @var User
	 */
	private $lead;

	/**
	 * @ORM\ManyToOne(targetEntity="Comment", inversedBy="discussion")
	 * @var Comment
	 */
	private $root;

	/**
	 * @ORM\ManyToOne(targetEntity="Tag", inversedBy="discussions")
	 * @var Tag
	 */
	private $tag;

	/**
	 * @ORM\OneToMany(targetEntity="Vote", mappedBy="discussion")
	 * @var ArrayCollection|Vote[]
	 */
	private $votes;

	public function __construct(Post $post, Tag $tag, User $lead, $title)
	{
		$this->post = $post;
		$this->tag = $tag;
		$this->lead = $lead;
		$this->title = $title;
		$this->votes = new ArrayCollection();
	}

	/**
	 * @return Post
	 */
	public function getPost()
	{
		return $this->post;
	}

	/**
	 * @param Post $post
	 * @return Discussion
	 */
	public function setPost(Post $post)
	{
		$this->post = $post;
		return $this;
	}

	/**
	 * @return Tag
	 */
	public function getTag()
	{
		return $this->tag;
	}

	/**
	 * @param Tag $tag
	 * @return Discussion
	 */
	public function setTag(Tag $tag)
	{
		$this->tag = $tag;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 * @return Discussion
	 */
	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}
}
