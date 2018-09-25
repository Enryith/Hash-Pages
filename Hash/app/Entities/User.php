<?php
namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Entities\Traits;
use LaravelDoctrine\ORM\Auth;

/**
 * @ORM\Entity
 * @ORM\Table
 */
class User implements Authenticatable
{
	use Auth\Authenticatable;
	use Traits\Id;

	/**
	 * Warning: only use getters to get this
	 * field or bad things will happen!
	 * @ORM\Column(type="string")
	 * @var string
	 */
	public $username;

	/**
	 * Warning: only use getters to get this
	 * field or bad things will happen!
	 * @ORM\Column(type="string")
	 * @var string
	 */
	public $email;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	protected $name;

	/**
	 * @var Settings
	 * @ORM\OneToOne(targetEntity="Settings", mappedBy="user")
	 */
	protected $settings;

	/**
	 * @return string
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * @param string $username
	 * @return User
	 */
	public function setUsername($username)
	{
		$this->username = $username;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return User
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 * @return $this
	 */
	public function setEmail($email)
	{
		$this->email = $email;
		return $this;
	}

	/**
	 * @return Settings
	 */
	public function getSettings()
	{
		return $this->settings;
	}

	/**
	 * @param Settings $settings
	 */
	public function setSettings($settings)
	{
		$this->settings = $settings;
	}


}
