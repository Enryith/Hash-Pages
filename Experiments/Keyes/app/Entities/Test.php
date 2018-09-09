<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table
 */
class Test
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	/**
	 * @var String $var1
	 * @ORM\Column(type="string")
	 */
	protected $var1;
	/**
	 * @var int $var2
	 * @ORM\Column(type="integer")
	 */
	protected $var2;


	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id): void
	{
		$this->id = $id;
	}

	/**
	 * @return String
	 */
	public function getVar1(): String
	{
		return $this->var1;
	}

	/**
	 * @param String $var1
	 */
	public function setVar1(String $var1)
	{
		$this->var1 = $var1;
	}

	/**
	 * @return integer
	 */
	public function getVar2()
	{
		return $this->var2;
	}

	/**
	 * @param integer $var2
	 */
	public function setVar2($var2)
	{
		$this->var2 = $var2;
	}
}
