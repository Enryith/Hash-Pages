<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Conversation
{
	use Traits\Id;

	/**
	 * @ORM\ManyToMany(targetEntity="User", inversedBy="conversations")
	 * @var ArrayCollection|User[]
	 */
	private $users;

	/**
	 * @ORM\OneToMany(targetEntity="Message", mappedBy="conversation")
	 * @var ArrayCollection|Message[]
	 */
	private $messages;


}