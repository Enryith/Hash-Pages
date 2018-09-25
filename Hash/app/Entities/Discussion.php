<?php
/**
 * Created by PhpStorm.
 * User: dknallur
 * Date: 9/20/2018
 * Time: 6:34 PM
 */

namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Discussion
{
    use Traits\Id;

    /**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="discussion")
     * @var Post
     */
    private $post;

    /**
     * @ORM\ManyToOne(targetEntity="Score", inversedBy="discussion")
     * @var Score
     */
    private $score;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="leading")
     * @var User
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