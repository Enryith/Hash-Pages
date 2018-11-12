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
	 * @ORM\Column(type="string", length=255)
	 * @var string
	 */
	private $title;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 * @var string
	 */
	private $link;

	/**
	 * @ORM\Column(type="text")
	 * @var string
	 */
	private $body;

	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="posts")
	 * @var User
	 */
	private $author;

	/**
	 * @ORM\OneToMany(targetEntity="Discussion", mappedBy="post")
	 * @var ArrayCollection|Discussion[]
	 */
	private $discussions;

	/**
	 * @ORM\Column(type="datetime" nullable=true)
	 * @var \DateTime
	 */
	private $recentActivity;

	public function __construct(User $user, $title, $link, $body)
	{
		$this->setAuthor($user);
		$this->title = $title;
		$this->link = $link;
		$this->body = $body;
		$this->recentActivity = new \DateTime('now');
		$this->discussions = new ArrayCollection();
	}

	/**
	 * @return Discussion[]|ArrayCollection
	 */
	public function getDiscussions()
	{
		return $this->discussions;
	}

	public function addDiscussion(Discussion $discussion)
	{
		if(!$this->discussions->contains($discussion))
		{
			$this->discussions->add($discussion);
			$discussion->setPost($this);
		}

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
	 * @return \DateTime
	 */
	public function getRecentActivity()
	{
		return $this->recentActivity;
	}

	/**
	 * @param \DateTime $recentActivity
	 * @return Post
	 */
	public function setRecentActivity(\DateTime $recentActivity)
	{
		$this->recentActivity = $recentActivity;
		return $this;
	}

	/**
	 * @return Post
	 */
	public function bump()
	{
		return $this->setRecentActivity(new \DateTime('now'));
	}

}
