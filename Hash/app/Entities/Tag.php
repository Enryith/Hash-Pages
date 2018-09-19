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
     * @ORM\score
     * @ORM\Column(type="score")
     * @ORM\ManyToOne(score="App\Entities\Score", inversedBy="Tag")
     * @var Score
     */
    private $score;

    /**
     * @ORM\Tag
     * @ORM\Column(type="string")
     * @var string
     */
    private $Tag;

    public function __construct(){

    }

    /**
     * @return Score
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param Score $score
     * @return Tag
     */
    public function setScore($score)
    {
        $this->score = $score;
        return $this;
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->Tag;
    }

    /**
     * @param string $Tag
     * @return Tag
     */
    public function setTag($Tag)
    {
        $this->Tag = $Tag;
        return $this;
    }


}