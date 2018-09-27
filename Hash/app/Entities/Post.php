<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Post
{
	use Traits\Id;

	/**
	 * @ORM\OneToMany(targetEntity="Score", mappedBy="post")
	 * @var ArrayCollection|Score[]
	 */
	private $scores;

	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="posts")
	 * @var User
	 */
	private $author;

	/**
	 * @ORM\OneToMany(targetEntity="Discussion", mappedBy="post")
	 * @var ArrayCollection|Discussion[]
	 */
	private $discussion;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @var string
	 */
	private $title;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @var string
	 */
	private $link;

	/**
	 * @ORM\Column(type="text")
	 * @var string
	 */
	private $body;

	/**
	 * @ORM\Column(type="integer")
	 * @var integer
	 */
	private $agree;

	/**
	 * @ORM\Column(type="integer")
	 * @var integer
	 */
	private $disagree;

	public function __construct(User $user, $title, $link, $body)
	{
		$this->setAuthor($user);
		$this->title = $title;
		$this->link = $link;
		$this->body = $body;
		$this->agree = 0;
		$this->disagree = 0;
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
	 * @return Post
	 */
	public function setAuthor(User $author)
	{
		$author->addPost($this);
		$this->author = $author;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getBody()
	{
		return $this->body;
	}

	/**
	 * @param string $body
	 * @return Post
	 */
	public function setBody($body)
	{
		$this->body = $body;
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
	 * @return Post
	 */
	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getLink()
	{
		return $this->link;
	}

	/**
	 * @param string $link
	 * @return Post
	 */
	public function setLink($link)
	{
		$this->link = $link;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getAgree()
	{
		return $this->agree;
	}

	/**
	 * @param int $agree
	 * @return Post
	 */
	public function setAgree($agree)
	{
		$this->agree = $agree;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getDisagree()
	{
		return $this->disagree;
	}

	/**
	 * @param int $disagree
	 * @return Post
	 */
	public function setDisagree($disagree)
	{
		$this->disagree = $disagree;
		return $this;
	}
}
