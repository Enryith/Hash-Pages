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

	const THEMES = [
		'sandstone' => [
			'text' => "Sandstone (light)",
			'href' => "https://stackpath.bootstrapcdn.com/bootswatch/4.1.3/sandstone/bootstrap.min.css",
			'integrity' => "sha384-CfCAYEgrdtRrpvjGKxoaRy5ge1ggMbxNSpEkY+XqdfdRTUkRrYZVB2z99E7BsEDZ",
		],
		'pulse' => [
			'text' => "Pulse (light)",
			'href' => "https://stackpath.bootstrapcdn.com/bootswatch/4.1.3/pulse/bootstrap.min.css",
			'integrity' => "sha384-c0rj6xRl6Zm4U4BwLaWhUoP/xPI8Sq+9Gt0F+JO5DSLZN0Ur0Ihc6rU59Rbgk1zV",
		],
		'solar' => [
			'text' => "Solar (solarized)",
			'href' => "https://stackpath.bootstrapcdn.com/bootswatch/4.1.3/solar/bootstrap.min.css",
			'integrity' => "sha384-h5kYMLFNMyLXdVYK3MKZeOfXMdU6XqV1do5KyjoYZGlW1FJOj+5qr9u1d7NNCH4N",
		],
		'darkly' => [
			'text' => "Darkly (dark)",
			'href' => "https://stackpath.bootstrapcdn.com/bootswatch/4.1.3/darkly/bootstrap.min.css",
			'integrity' => "sha384-w+yWASP3zYNxxvwoQBD5fUSc1tctKq4KUiZzxgkBSJACiUp+IbweVKvsEhMI+gz7",
		],
		'cyborg' => [
			'text' => "Cyborg (amoled)",
			'href' => "https://stackpath.bootstrapcdn.com/bootswatch/4.1.3/cyborg/bootstrap.min.css",
			'integrity' => "sha384-4DAPMwiyOJv/C/LvTiUsW5ueiD7EsaAhwUKO0Llp+fWzT40XrmAbayhVP00bAJVa",
		]
	];

	public static function themeOptions(){
		$arr = [];
		foreach (self::THEMES as $theme => $options){
			$arr[$theme] = $options['text'];
		}
		return $arr;
	}

	/**
	 * @ORM\Column(type="string", options={"default" : "sandstone"})
	 * @var string
	 */
	private $theme;

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
	 * @ORM\ManyToMany(targetEntity="Chat", mappedBy="users")
	 * @var ArrayCollection|Chat[]
	 */
	private $chat;

	/**
	 * @ORM\OneToMany(targetEntity="Comment", mappedBy="author")
	 * @var ArrayCollection|Comment[]
	 */
	private $comments;

	/**
	 * @ORM\OneToMany(targetEntity="Vote", mappedBy="user")
	 * @var ArrayCollection|Vote[]
	 */
	private $votes;

	public function __construct()
	{
		$this->theme = "sandstone";
		$this->picture = "";
		$this->bio = "";
		$this->posts = new ArrayCollection();
		$this->leading = new ArrayCollection();
		$this->votes = new ArrayCollection();
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
	 * @return User
	 */
	public function setTheme($theme)
	{
		$this->theme = $theme;
		return $this;
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
		return str_replace("public", "/storage", $this->picture);
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

	/**
	 * @param Chat $chat
	 * @return $this
	 */
	public function addChat(Chat $chat)
	{
		if (!$this->chat->contains($chat)) {
			$this->chat->add($chat);
			$chat->addUser($this);
		}
		return $this;
	}
}
