<?php

namespace App\Security\Entity;

use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;

#[ORM\Entity]
class User extends Timestampable
{
    #[OA\Property(type: 'integer', readOnly: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public string $id;

    #[OA\Property(type: 'string', readOnly: true)]
    #[ORM\Column(type: 'string', length: 255, unique: true, nullable: false)]
    public string $email;

    #[OA\Property(type: 'string')]
    #[ORM\Column(type: 'string', length: 64, unique: true, nullable: true)]
    public ?string $nickname;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): User
    {
        $this->id = $id;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(?string $nickname): User
    {
        $this->nickname = $nickname;
        return $this;
    }
}
