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
     * @ORM\score
     * @ORM\Column(type="Score")
     * @ORM\OneToOne(score="App/Entities/Score", inversedBy="Post")
     * @var score
     */
    private $score;

    /**
     * @ORM\user
     * @ORM\Column(type="User")
     * @ORM\ManyToOne(user="App/Entities/User", inversedBy="Post")
     * @var score
     */
    private $user;

    /**
     * @ORM\discussion
     * @ORM\Column(type="discussion")
     * @ORM\OneToMany(discussion="App\Entities\Discussion", inversedBy="Post")
     * @var Discussion
     */
    private $discussion;

    /**
     * @ORM\Body
     * @ORM\Column(type="string")
     * @var string
     */
    private $Body;
    /**
     * @ORM\Title
     * @ORM\Column(type="string")
     * @var string
     */
    private $Title;
    /**
     * @ORM\Link
     * @ORM\Column(type="string")
     * @var string
     */
    private $Link;
    /**
     * @ORM\Agree
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $Agree;
    /**
     * @ORM\Disagree
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $Disagree;

    public function __construct($User, $Body, $Title, $Link)
    {
        $this->User = $User;
        $this->Body = $Body;
        $this->Title = $Title;
        $this->Link = $Link;
        $this->Agree = 0;
        $this->Disagree = 0;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getBody()
    {
        return $this->Body;
    }

    public function getTitle()
    {
        return $this->Title;
    }

    public function getLink()
    {
        return $this->Link;
    }

    public function setUser($User)
    {
        $this->user = $User;
    }

    public function setBody($Body)
    {
        $this->Body = $Body;
    }

    public function setTitle($Title)
    {
        $this->Title = $Title;
    }

    public function setLink($Link)
    {
        $this->Link = $Link;
    }

    public function agreeIncrement()
    {
        $this->agree++;
    }

    public function agreeDecrement()
    {
        $this->agree--;
    }

    public function disagreeIncrement()
    {
        $this->disagree++;
    }

    public function disagreeDecrement()
    {
        $this->disagree--;
    }

    /**
     * @return Score
     */
    public function getDiscussion(): Score
    {
        return $this->discussion;
    }

    /**
     * @param Score $discussion
     */
    public function setDiscussion(Score $discussion): void
    {
        $this->discussion = $discussion;
    }
}