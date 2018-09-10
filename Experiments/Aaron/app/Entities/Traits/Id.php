<?php
namespace App\Entities\Traits;

trait Id
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 * @var integer
	 */
	protected $id;

	/**
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}
}
