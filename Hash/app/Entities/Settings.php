<?php
namespace App\Entities;

use App\Entities\Traits;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table
 */
class Settings
{
	use Traits\Id;

	const LUMEN = "Lumen";
	const DARKLY = "Darkly";
	const SOLAR = "Solar";

	/**
	 * @var User
	 * @ORM\OneToOne(targetEntity="User", inversedBy="settings")
	 */
	protected $user;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	protected $theme;

	/**
	 * @return User
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * @param User $user
	 */
	public function setUser($user)
	{
		$this->user = $user;
	}

	/**
	 * @return string
	 */
	public function getTheme()
	{
		return $this->theme;
	}

	/**
	 * @param string $theme
	 */
	public function setTheme($theme)
	{
		$this->theme = $theme;
	}
}
