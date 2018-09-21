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
     * @ORM\discussion
     * @ORM\Column(type="discussion")
     * @ORM\ManyToOne(discussion="App/Entities/Discussion", inversedBy="Comment")
     * @var discussion
     */
    private $discussion;

    /**
     * @ORM\parent
     * @ORM\Column(type="comment")
     * @ORM\ManyToOne(comment="App/Entities/Comment", inversedBy="Comment")
     * @var comment
     */
    private $parent;

    /**
     * @ORM\user
     * @ORM\Column(type="user")
     * @ORM\ManyToOne(user="App/Entities/User", inversedBy="Comment")
     * @var user
     */
    private $user;

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
     * @return discussion
     */
    public function getDiscussion(): discussion
    {
        return $this->discussion;
    }

    /**
     * @param discussion $discussion
     */
    public function setDiscussion(discussion $discussion): void
    {
        $this->discussion = $discussion;
    }

    /**
     * @return Comment
     */
    public function getParent(): Comment
    {
        return $this->parent;
    }

    /**
     * @param Comment $parent
     */
    public function setParent(Comment $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return user
     */
    public function getUser(): user
    {
        return $this->user;
    }

    /**
     * @param user $user
     */
    public function setUser(user $user): void
    {
        $this->user = $user;
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