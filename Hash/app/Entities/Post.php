<?php

namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table
 */
class Post
{
    use Traits\Id;

    /**
     * @ORM\Column(type="score")
     * @ORM\OneToOne(targetEntity="App/Entities/Score", mappedBy="post")
     * @var Score
     */
    private $score;

    /**
     * @ORM\Column(type="User")
     * @ORM\ManyToOne(targetEntity="App/Entities/User", inversedBy="posts")
     * @var score
     */
    private $author;

    /**
     * @ORM\Column(type="discussion")
     * @ORM\OneToMany(targetEntity="App\Entities\Discussion", mappedBy="post")
     * @var Discussion
     */
    private $discussion;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $Body;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $Title;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $Link;
    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $Agree;
    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $Disagree;


}