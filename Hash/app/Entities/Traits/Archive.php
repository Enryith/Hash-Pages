<?php

namespace App\Entities\Traits;

trait Archive
{
    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $archived;

    /**
     * @return bool
     */
    public function isArchived()
    {
        return $this->archived;
    }

    /**
     * @param bool $archived
     * @return $this
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;
        return $this;
    }
}
