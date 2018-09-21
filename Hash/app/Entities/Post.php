<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Post
{
    use Traits\Id;

    /**
     * @ORM\OneToMany(targetEntity="Score", mappedBy="post")
     * @var ArrayCollection|Score[]
     */
    private $scores;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="posts")
     * @var User
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="Discussion", mappedBy="post")
     * @var ArrayCollection|Discussion[]
     */
    private $discussion;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $body;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $link;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $agree;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $disagree;


}