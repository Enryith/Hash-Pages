<?php
namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Entities\Traits;
use \LaravelDoctrine\ORM\Auth;

/**
 * @ORM\Entity
 * @ORM\Table
 */
class User implements Authenticatable
{
	use Auth\Authenticatable;
	use Traits\Id;

    /**
     * @ORM\comments
     * @ORM\Column(type="comment")
     * @ORM\OneToMany(comments="App\Entities\Comment", inversedBy="User")
     * @var comment
     */
    private $comments;

    /**
     * @ORM\posts
     * @ORM\Column(type="post")
     * @ORM\OneToMany(posts="App\Entities\Post", inversedBy="User")
     * @var post
     */
    private $posts;

    /**
     * @ORM\followers
     * @ORM\Column(type="user")
     * @ORM\OneToMany(followers="App\Entities\User", inversedBy="User")
     * @var user
     */
    private $followers;

    /**
     * @ORM\following
     * @ORM\Column(type="user")
     * @ORM\ManyToOne(following="App\Entities\User", inversedBy="User")
     * @var user
     */
    private $following;

    /**
     * @ORM\subscriptions
     * @ORM\Column(type="tag")
     * @ORM\ManyToMany(subscriptions="App\Entities\Tag", inversedBy="User")
     * @var tag
     */
    private $subscriptions;

    /**
     * @ORM\curate
     * @ORM\Column(type="tag")
     * @ORM\ManyToMany(curate="App\Entities\Tag", inversedBy="User")
     * @var tag
     */
    private $curate;

	/**
	 * Warning: only use getters to get this
	 * field or bad things will happen!
	 * @ORM\Column(type="string")
	 * @var string
	 */
	public $username;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $password;

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
	 * @return User
	 */
	public function setEmail($email)
	{
		$this->email = $email;
		return $this;
	}

    /**
     * @return comment
     */
    public function getComments(): comment
    {
        return $this->comments;
    }

    /**
     * @param comment $comments
     */
    public function setComments(comment $comments): void
    {
        $this->comments = $comments;
    }

    /**
     * @return post
     */
    public function getPosts(): post
    {
        return $this->posts;
    }

    /**
     * @param post $posts
     */
    public function setPosts(post $posts): void
    {
        $this->posts = $posts;
    }

    /**
     * @return User
     */
    public function getFollowers(): User
    {
        return $this->followers;
    }

    /**
     * @param User $followers
     */
    public function setFollowers(User $followers): void
    {
        $this->followers = $followers;
    }

    /**
     * @return User
     */
    public function getFollowing(): User
    {
        return $this->following;
    }

    /**
     * @param User $following
     */
    public function setFollowing(User $following): void
    {
        $this->following = $following;
    }

    /**
     * @return tag
     */
    public function getSubscriptions(): tag
    {
        return $this->subscriptions;
    }

    /**
     * @param tag $subscriptions
     */
    public function setSubscriptions(tag $subscriptions): void
    {
        $this->subscriptions = $subscriptions;
    }

    /**
     * @return tag
     */
    public function getCurate(): tag
    {
        return $this->curate;
    }

    /**
     * @param tag $curate
     */
    public function setCurate(tag $curate): void
    {
        $this->curate = $curate;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }


}
