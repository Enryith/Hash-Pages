<?php
/**
 * Created by PhpStorm.
 * User: dknallur
 * Date: 9/20/2018
 * Time: 6:56 PM
 */

namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;

class Comment
{
    use Traits\Id;

    /**
     * @ORM\Column(type="discussion")
     * @ORM\ManyToOne(targetEntity="App/Entities/Discussion", inversedBy="comment")
     * @var discussion
     */
    private $discussion;

    /**
     * @ORM\Column(type="comment")
     * @ORM\ManyToOne(targetEntity="App/Entities/Comment", inversedBy="child")
     * @var comment
     */
    private $parent;

    /**
     * @ORM\Column(type="comment")
     * @ORM\OneToMany(targetEntity="App/Entities/Comment", mappedBy ="parent")
     * @var comment
     */
    private $child;

    /**
     * @ORM\Column(type="user")
     * @ORM\ManyToOne(targetEntity="App/Entities/User", inversedBy="comment")
     * @var user
     */
    private $author;

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