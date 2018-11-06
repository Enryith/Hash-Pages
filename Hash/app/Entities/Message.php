<?php

namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Message
{
	use Traits\Id;

	/**
	 * @ORM\ManyToOne(targetEntity="Chat", inversedBy="messages")
	 * @var Chat
	 */
	private $chat;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $message;

	/**
	 * @ORM\ManyToOne(targetEntity="User")
	 * @var User
	 */
	private $user;

	public function __construct(User $user, Chat $chat, $message)
	{
		$this->user = $user;
		$this->chat = $chat;
		$this->message = $message;
	}

	/**
	 * @return string
	 */
	public function getMessage(): string
	{
		return $this->message;
	}

	/**
	 * @param Chat $chat
	 */
	public function setChat(Chat $chat): void
	{
		$this->chat = $chat;
	}

	/**
	 * @return User
	 */
	public function getUser(): User
	{
		return $this->user;
	}


}