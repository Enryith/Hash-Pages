<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Chat
{
	use Traits\Id;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $title;

	/**
	 * @ORM\ManyToMany(targetEntity="User", inversedBy="chat")
	 * @var ArrayCollection|User[]
	 */
	private $users;

	/**
	 * @ORM\OneToMany(targetEntity="Message", mappedBy="chat")
	 * @var ArrayCollection|Message[]
	 */
	private $messages;


	public function __construct($title)
	{
		$this->title = $title;
		$this->users = new ArrayCollection();
		$this->messages = new ArrayCollection();
	}

	/**
	 * @return User[]|ArrayCollection
	 */
	public function getUsers()
	{
		return $this->users;
	}

	/**
	 * @param User $user
	 */
	public function addUser(User $user){
		if(!$this->users->contains($user))
		{
			$this->users->add($user);
			$user->addChat($this);
		}
	}

	/**
	 * @return Message[]|ArrayCollection
	 */
	public function getMessages()
	{
		return $this->messages;
	}

	public function addMessages(Message $message){
		if(!$this->messages->contains($message))
		{
			$this->messages->add($message);
			$message->setChat($this);
		}

		return $this;
	}

	/**
	 * @return string
	 */
	public function getTitle(): string
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle(string $title): void
	{
		$this->title = $title;
	}
}