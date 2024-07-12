<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use OpenApi\Attributes as OA;

#[Entity(readOnly: false)]
class User extends Timestampable
{
    #[OA\Property(type: "integer")]
    #[Id, Column(type: "integer"), GeneratedValue(strategy: "IDENTITY")]
    private ?int $id;

    #[OA\Property(type: "string")]
    #[Column(type: "string", length: 255, unique: true, nullable: false)]
    private string $email;

    #[OA\Property(type: "string", writeOnly: true)]
    #[Column(type: "string", length: 255, nullable: false)]
    private string $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): User
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

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }
}