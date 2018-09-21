<?php
/**
 * Created by PhpStorm.
 * User: dknallur
 * Date: 9/20/2018
 * Time: 6:34 PM
 */

namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;

class Discussion
{
    use Traits\Id;

    /**
     * @ORM\Column(type="post")
     * @ORM\ManyToOne(targetEntity="App\Entities\Post", inversedBy="discussion")
     * @var post
     */
    private $post;

    /**
     * @ORM\Column(type="score")
     * @ORM\ManyToOne(targetEntity="App\Entities\Score", inversedBy="discussion")
     * @var score
     */
    private $score;

    /**
     * @ORM\Column(type="user")
     * @ORM\ManyToOne(targetEntity="App\Entities\User", inversedBy="leading")
     * @var user
     */
    private $lead;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $comment;

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