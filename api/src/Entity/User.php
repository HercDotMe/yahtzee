<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use JsonSerializable;
use OpenApi\Attributes as OA;

#[Entity]
class User extends Timestampable implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 255)]
    private ?string $email;

    #[ORM\Column(length: 255)]
    #[OA\Property(type: 'string', format: 'password', writeOnly: true)]
    private ?string $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): User
    {
        $this->id = $id;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): User
    {
        $this->password = $password;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'createdAt' => $this->createdAt->format('Y-m-d\TH:i:s.v\Z'),
            'updatedAt' => $this->updatedAt->format('Y-m-d\TH:i:s.v\Z'),
        ];
    }
}
