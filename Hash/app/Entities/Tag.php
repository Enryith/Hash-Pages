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
	 * @ORM\OneToMany(targetEntity="Score", mappedBy="tag")
	 * @var ArrayCollection|Score[]
	 */
	private $scores;

	/**
	 * @ORM\ManyToMany(targetEntity="User", inversedBy="subscriptions")
	 * @var ArrayCollection|User[]
	 */
	private $subscribers;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $tag;

	public function __construct($tag){
		$this->tag = $tag;
		$this->subscribers = new ArrayCollection();
		$this->scores = new ArrayCollection();
	}

	public function addScore(Score $score){
		if(!$this->scores->contains($score)){
			$this->scores->add($score);
			$score->setTag($this);
		}
		return $this;
	}

	/**
	 * @return Score[]|ArrayCollection
	 */
	public function getScores()
	{
		return $this->scores;
	}

	/**
	 * @param Score[]|ArrayCollection $scores
	 */
	public function setScores($scores): void
	{
		$this->scores = $scores;
	}

	/**
	 * @return User[]|ArrayCollection
	 */
	public function getSubscribers()
	{
		return $this->subscribers;
	}

	/**
	 * @param User[]|ArrayCollection $subscribers
	 */
	public function setSubscribers($subscribers): void
	{
		$this->subscribers = $subscribers;
	}

	/**
	 * @return string
	 */
	public function getTag(): string
	{
		return $this->tag;
	}

	/**
	 * @param string $tag
	 */
	public function setTag(string $tag): void
	{
		$this->tag = $tag;
	}


}
