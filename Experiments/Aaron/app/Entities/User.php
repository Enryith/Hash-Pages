<?php
namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Entities\Traits;

/**
 * @ORM\Entity
 * @ORM\Table
 */
class User implements Authenticatable
{
	use \LaravelDoctrine\ORM\Auth\Authenticatable;
	use Traits\Id;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	protected $username;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	protected $nameFirst;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	protected $nameLast;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	protected $email;

	public function getFormValue($key) {
		return $this->$key;
	}
}
