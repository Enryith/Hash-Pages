<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Tag
{
    use Traits\Id;

    /**
     * @ORM\OneToMany(targetEntity="Score", mappedBy="tag")
     * @var ArrayCollection|Score[]
     */
    private $scores;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="subscriptions")
     * @var ArrayCollection|User[]
     */
    private $subscribers;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $tag;


}