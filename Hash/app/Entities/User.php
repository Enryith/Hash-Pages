<?php
namespace App\Entities;

use Collective\Html\Eloquent\FormAccessible;
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
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $name;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $picture;

	/**
	 * @ORM\Column(type="string", length=300)
	 * @var string
	 */
	private $bio;

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
	 * @ORM\OneToMany(targetEntity="Post", mappedBy="author")
	 * @var ArrayCollection|Post[]
	 */
	private $posts;

	/**
	 * @ORM\OneToMany(targetEntity="Discussion", mappedBy="author")
	 * @var ArrayCollection|Discussion[]
	 */
	private $leading;

	/**
	 * @ORM\OneToMany(targetEntity="Comment", mappedBy="author")
	 * @var ArrayCollection|Comment[]
	 */
	private $comments;

	/**
	 * @ORM\ManyToMany(targetEntity="Conversation", mappedBy="users")
	 * @var ArrayCollection|Conversation[]
	 */
	private $conversations;

	/**
	 * @ORM\ManyToMany(targetEntity="Conversation", mappedBy="agree")
	 * @var ArrayCollection|Conversation[]
	 */
	private $agree;

	/**
	 * @ORM\ManyToMany(targetEntity="Conversation", mappedBy="disagree")
	 * @var ArrayCollection|Conversation[]
	 */
	private $disagree;

	public function __construct()
	{
		$this->picture = "";
		$this->bio = "";
		$this->posts = new ArrayCollection();
		$this->leading = new ArrayCollection();
		$this->agree = new ArrayCollection();
		$this->disagree = new ArrayCollection();
	}

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
	 * @return string
	 */
	public function getPicture()
	{
		return $this->picture;
	}

	/**
	 * @return string
	 */
	public function getPicturePublic()
	{
		return str_replace("public","/storage", $this->picture);
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

	/**
	 * @return string
	 */
	public function getBio()
	{
		return $this->bio;
	}

	/**
	 * @param string $bio
	 * @return User
	 */
	public function setBio($bio)
	{
		$this->bio = $bio ?? "";
		return $this;
	}

	public function getFormValue($key)
	{
		return $this->$key;
	}

	/**
	 * @param Post $post
	 * @return $this
	 */
	public function addPost(Post $post)
	{
		if (!$this->posts->contains($post)) {
			$this->posts->add($post);
			$post->setAuthor($this);
		}
		return $this;
	}
}
