<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Message
{
	use Traits\Id;

	/**
	 * @ORM\ManyToOne(targetEntity="Conversation", inversedBy="messages")
	 * @var Conversation
	 */
	private $conversation;

	/**
	 * @ORM\Column(type="text")
	 * @var string
	 */
	private $message;
}