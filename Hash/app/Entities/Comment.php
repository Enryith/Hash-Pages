<?php

namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

/**
 * @ORM\Entity
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Comment
{
	use Traits\Id;
	use SoftDeleteableEntity;

	/**
	 * @ORM\Column(type="text")
	 * @var string
	 */
	private $comment;

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
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="comments")
	 * @var User
	 */
	private $author;

	/**
	 * @ORM\OneToMany(targetEntity="Comment", mappedBy ="parent")
	 * @var ArrayCollection|Comment[]
	 */
	private $children;

	public function __construct(Discussion $root, User $user, $comment, Comment $parent = null)
	{
		$this->comment = $comment;
		$this->discussion = $root;
		$this->author = $user;
		$this->parent = $parent;
		$this->children = new ArrayCollection();
	}

	/**
	 * @return string
	 */
	public function getComment()
	{
		return $this->comment;
	}

	/**
	 * @param string $comment
	 * @return Comment
	 */
	public function setComment($comment)
	{
		$this->comment = $comment;
		return $this;
	}

	/**
	 * @return Discussion
	 */
	public function getDiscussion()
	{
		return $this->discussion;
	}

	/**
	 * @param Discussion $discussion
	 * @return Comment
	 */
	public function setDiscussion(Discussion $discussion)
	{
		$this->discussion = $discussion;
		return $this;
	}

	/**
	 * @return Comment
	 */
	public function getParent()
	{
		return $this->parent;
	}

	/**
	 * @param Comment $parent
	 * @return Comment
	 */
	public function setParent(Comment $parent)
	{
		$this->parent = $parent;
		return $this;
	}

	/**
	 * @return User
	 */
	public function getAuthor()
	{
		return $this->author;
	}

	/**
	 * @param User $author
	 * @return Comment
	 */
	public function setAuthor(User $author)
	{
		$this->author = $author;
		return $this;
	}

	/**
	 * @return Comment[]|ArrayCollection
	 */
	public function getChildren()
	{
		return $this->children;
	}
}
