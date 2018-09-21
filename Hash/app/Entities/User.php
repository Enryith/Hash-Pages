<?php
namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use Illuminate\Contracts\Auth\Authenticatable;
use LaravelDoctrine\ORM\Auth;

/**
 * @ORM\Entity
 */
class User implements Authenticatable
{
	use Auth\Authenticatable;
	use Traits\Id;

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
