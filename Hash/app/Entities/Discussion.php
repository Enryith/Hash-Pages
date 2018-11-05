<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping AS ORM;
use Illuminate\Support\Arr;

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
	 * @ORM\OneToMany(targetEntity="Comment", mappedBy="discussion")
	 * @var ArrayCollection|Comment[]
	 */
	private $comments;

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

	/**
	 * @ORM\Column(type="integer")
	 * @var integer
	 */
	private $cachedAgree;

	/**
	 * @ORM\Column(type="integer")
	 * @var integer
	 */
	private $cachedDisagree;

	public function __construct(Post $post, Tag $tag, User $lead, $title)
	{
		$this->post = $post;
		$this->tag = $tag;
		$this->lead = $lead;
		$this->title = $title;
		$this->cachedAgree = 0;
		$this->cachedDisagree = 0;
		$this->votes = new ArrayCollection();
		$this->comments = new ArrayCollection();
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

	/**
	 * @return int
	 */
	public function getCachedAgree()
	{
		return $this->cachedAgree;
	}

	/**
	 * @return int
	 */
	public function getCachedDisagree()
	{
		return $this->cachedDisagree;
	}

	/**
	 * @return Comment[]|ArrayCollection
	 */
	public function getComments()
	{
		return $this->comments;
	}

	/**
	 * @param Comment $comment
	 */
	public function addComment(Comment $comment)
	{
		if (!$this->comments->contains($comment))
		{
			$this->comments->add($comment);
			$comment->setDiscussion($this);
		}
	}

	/**
	 * Gets if a user has voted on a specific discussion
	 * @param User|null $user
	 * @return null|string
	 */
	public function hasVoted(User $user = null)
	{
		if (!$user) return null;

		/** @var Vote[]|ArrayCollection $votes */
		$votes = $this->votes->matching(Criteria::create()
			->where(Criteria::expr()->eq("user", $user))
			->andWhere(Criteria::expr()->eq("discussion", $this))
		);

		if ($votes->count() == 1)
		{
			return $votes[0]->getType();
		}
		else
		{
			return null;
		}
	}

	/**
	 * @return ArrayCollection
	 */
	public function getRootComments()
	{
		return $this->comments->matching(Criteria::create()
			->where(Criteria::expr()->isNull("parent"))
		);
	}

	public function delta($type, $delta)
	{
		switch ($type) {
			case Vote::AGREE:
				$this->cachedAgree += $delta;
				break;
			case Vote::DISAGREE:
				$this->cachedDisagree += $delta;
				break;
			default:
		}
	}
}
