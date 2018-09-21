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
     * @ORM\OneToMany(tag="App/Entities/Tag", inversedBy="Score")
     * @var tag
     */
    private $tag;

    /**
     * @ORM\discussion
     * @ORM\Column(type="discussion")
     * @ORM\OneToMany(discussion="App\Entities\Discussion", inversedBy="Score")
     * @var discussion
     */
    private $discussion;

    /**
     * @ORM\post
     * @ORM\Column(type="Post")
     * @ORM\OneToOne(post="App/Entities/Post", inversedBy="Score")
     * @var post
     */
    private $post;

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

    /**
     * @return tag
     */
    public function getTag(): tag
    {
        return $this->tag;
    }

    /**
     * @param tag $tag
     */
    public function setTag(tag $tag): void
    {
        $this->tag = $tag;
    }

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
     * @return int
     */
    public function getContributes(): int
    {
        return $this->contributes;
    }

    /**
     * @param int $contributes
     */
    public function setContributes(int $contributes): void
    {
        $this->contributes = $contributes;
    }

    /**
     * @return int
     */
    public function getSpam(): int
    {
        return $this->spam;
    }

    /**
     * @param int $spam
     */
    public function setSpam(int $spam): void
    {
        $this->spam = $spam;
    }


}