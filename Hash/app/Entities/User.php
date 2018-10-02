<?php
namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Entities\Traits;
use LaravelDoctrine\ORM\Auth;

/**
 * @ORM\Entity
 */
class User implements Authenticatable
{
	use Auth\Authenticatable;
	use Traits\Id;

	const LUMEN = "Lumen";
	const DARKLY = "Darkly";
	const SOLAR = "Solar";

	/**
	 * @ORM\OneToMany(targetEntity="Comment", mappedBy="author")
	 * @var ArrayCollection|Comment[]
	 */
	private $comments;

	/**
	 * @ORM\OneToMany(targetEntity="Post", mappedBy="author")
	 * @var ArrayCollection|Post[]
	 */
	private $posts;

	/**
	 * @ORM\ManyToMany(targetEntity="User", mappedBy="following")
	 * @var ArrayCollection|User[]
	 */
	private $followers;

	/**
	 * @ORM\ManyToMany(targetEntity="User", inversedBy="followers")
	 * @var ArrayCollection|User[]
	 */
	private $following;

	/**
	 * @ORM\ManyToMany(targetEntity="Tag", mappedBy="subscribers")
	 * @var ArrayCollection|Tag[]
	 */
	private $subscriptions;

	/**
	 * @ORM\OneToMany(targetEntity="Discussion", mappedBy="author")
	 * @var ArrayCollection|Discussion[]
	 */
	private $leading;

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
	 * @ORM\Column(type="string")
	 * @var string
	 */
	protected $picture;

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
	 * @param Post $post
	 * @return $this
	 */
	public function addPost(Post $post)
	{
		if (!$this->posts->contains($post))
		{
			$this->posts->add($post);
			$post->setAuthor($this);
		}
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPicture()
	{
		return $this->picture;
	}

	/**
	 * @param string $picture
	 * @return $this
	 */
	public function setPicture($picture)
	{
		$this->picture = $picture;
		return $this;
	}
}
