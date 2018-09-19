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
     * @ORM\tag
     * @ORM\Column(type="Tag")
     * @ORM\OneToMany(tag="App/Entities/Tag", inversedBy="score")
     * @var tag
     */
    private $tag;

    /**
     * @ORM\contributes
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $contributes;

    /**
     * @ORM\spam
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $spam;

    
}