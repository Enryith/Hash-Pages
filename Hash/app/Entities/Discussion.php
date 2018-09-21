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
     * @ORM\post
     * @ORM\Column(type="post")
     * @ORM\ManyToOne(post="App\Entities\Post", inversedBy="Discussion")
     * @var post
     */
    private $post;

    /**
     * @ORM\score
     * @ORM\Column(type="score")
     * @ORM\ManyToOne(score="App\Entities\Score", inversedBy="Discussion")
     * @var score
     */
    private $score;

    /**
     * @ORM\lead
     * @ORM\Column(type="user")
     * @ORM\OneToOne(user="App\Entities\User", inversedBy="Discussion")
     * @var user
     */
    private $lead;

    /**
     * @ORM\title
     * @ORM\Column(type="string")
     * @var string
     */
    private $title;

    /**
     * @ORM\comment
     * @ORM\Column(type="string")
     * @var string
     */
    private $comment;

    /**
     * @ORM\agree
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $agree;

    /**
     * @ORM\disagree
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $disagree;



    /**
     * @return post
     */
    public function getPost(): post
    {
        return $this->post;
    }

    /**
     * @param post $post
     */
    public function setPost(post $post): void
    {
        $this->post = $post;
    }

    /**
     * @return score
     */
    public function getScore(): score
    {
        return $this->score;
    }

    /**
     * @param score $score
     */
    public function setScore(score $score): void
    {
        $this->score = $score;
    }

    /**
     * @return user
     */
    public function getLead(): user
    {
        return $this->lead;
    }

    /**
     * @param user $lead
     */
    public function setLead(user $lead): void
    {
        $this->lead = $lead;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return int
     */
    public function getAgree(): int
    {
        return $this->agree;
    }

    /**
     * @param int $agree
     */
    public function setAgree(int $agree): void
    {
        $this->agree = $agree;
    }

    /**
     * @return int
     */
    public function getDisagree(): int
    {
        return $this->disagree;
    }

    /**
     * @param int $disagree
     */
    public function setDisagree(int $disagree): void
    {
        $this->disagree = $disagree;
    }


}