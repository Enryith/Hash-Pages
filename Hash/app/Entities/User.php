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
     * @ORM\Column(type="comment")
     * @ORM\OneToMany(targetEntity="App\Entities\Comment", mappedBy="author")
     * @var comment
     */
    private $comments;

    /**
     * @ORM\Column(type="post")
     * @ORM\OneToMany(targetEntity="App\Entities\Post", mappedBy="author")
     * @var post
     */
    private $posts;

    /**
     * @ORM\Column(type="user")
     * @ORM\ManyToMany(targetEntity="App\Entities\User", mappedBy="following")
     * @var user
     */
    private $followers;

    /**
     * @ORM\Column(type="user")
     * @ORM\ManyToMany(targetEntity="App\Entities\User", inversedBy="followers")
     * @var user
     */
    private $following;

    /**
     * @ORM\Column(type="tag")
     * @ORM\ManyToMany(targetEntity="App\Entities\Tag", mappedBy="subscriber")
     * @var tag
     */
    private $subscriptions;

    /**
     * @ORM\Column(type="tag")
     * @ORM\ManyToMany(targetEntity="App\Entities\Tag", mappedBy="User")
     * @var tag
     */
    private $curate;

    /**
     * @ORM\Column(type="discussion")
     * @ORM\OneToMany(targetEntity="App\Entities\Discussion", mappedBy="lead")
     * @var discussion
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

}
