<?php

namespace App\Security\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;

#[ORM\MappedSuperclass]
class Timestampable
{
    #[OA\Property(type: 'string', readOnly: true)]
    #[ORM\Column(type: 'datetime', nullable: false, options: ['default' => "CURRENT_TIMESTAMP"])]
    protected DateTime $createdAt;

    #[OA\Property(type: 'string', readOnly: true)]
    #[ORM\Column(type: 'datetime', nullable: false, options: ['default' => "CURRENT_TIMESTAMP"])]
    protected DateTime $updatedAt;

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
