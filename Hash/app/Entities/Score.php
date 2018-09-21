<?php
/**
 * Created by PhpStorm.
 * User: dknallur
 * Date: 9/19/2018
 * Time: 3:46 PM
 */

namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table
 */
class Score
{
    use Traits\Id;

    /**
     * @ORM\Column(type="Tag")
     * @ORM\OneToMany(targetEntity="App/Entities/Tag", mappedBy="score")
     * @var tag
     */
    private $tag;

    /**
     * @ORM\Column(type="discussion")
     * @ORM\OneToMany(targetEntity="App\Entities\Discussion", mappedBy="score")
     * @var discussion
     */
    private $discussion;

    /**
     * @ORM\Column(type="Post")
     * @ORM\OneToOne(targetEntity="App/Entities/Post", inversedBy="score")
     * @var post
     */
    private $post;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $contributes;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $spam;

}