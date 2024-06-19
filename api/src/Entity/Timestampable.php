<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\MappedSuperclass;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;

#[MappedSuperclass]
class Timestampable
{
    #[Groups(["read"])]
    #[OA\Property(type: 'datetime')]
    #[Column(type: 'datetime', nullable: false, options: ['default' => "CURRENT_TIMESTAMP"])]
    protected DateTime $createdAt;

    #[Groups(["read"])]
    #[OA\Property(type: 'datetime')]
    #[Column(type: 'datetime', nullable: false, options: ['default' => "CURRENT_TIMESTAMP"])]
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