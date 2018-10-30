<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Tag
{
	use Traits\Id;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $tag;

	/**
	 * @ORM\OneToMany(targetEntity="Discussion", mappedBy="tag")
	 * @var ArrayCollection|Discussion[]
	 */
	private $discussions;

	public function __construct($tag){
		$this->tag = $tag;
		$this->discussions = new ArrayCollection();
	}

	public function addDiscussion(Discussion $discussion){
		if(!$this->discussions->contains($discussion))
		{
			$this->discussions->add($discussion);
			$discussion->setTag($this);
		}

		return $this;
	}

	/**
	 * @return Discussion[]|ArrayCollection
	 */
	public function getDiscussions()
	{
		return $this->discussions;
	}

	/**
	 * @return string
	 */
	public function getTag()
	{
		return $this->tag;
	}

	/**
	 * @param string $tag
	 * @return Tag
	 */
	public function setTag(string $tag)
	{
		$this->tag = $tag;
		return $this;
	}
}
