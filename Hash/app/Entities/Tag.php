<?php

namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table
 */
class Tag
{
    use Traits\Id;

    /**
     * @ORM\Column(type="score")
     * @ORM\ManyToOne(targetEntity="App\Entities\Score", inversedBy="tag")
     * @var Score
     */
    private $score;

    /**
     * @ORM\Column(type="user")
     * @ORM\ManyToMany(targetEntity="App\Entities\User", inversedBy="curate")
     * @var user
     */
    private $curators;

    /**
     * @ORM\Column(type="user")
     * @ORM\ManyToMany(targetEntity="App\Entities\User", inversedBy="subscriptions")
     * @var user
     */
    private $subscriber;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $Tag;


}