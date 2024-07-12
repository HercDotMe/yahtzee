<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[Entity(readOnly: false)]
class User extends Timestampable
{
    #[Groups(["read"])]
    #[OA\Property(type: 'int')]
    #[Assert\NotBlank]
    #[Id, Column(type: "integer"), GeneratedValue(strategy: "IDENTITY")]
    private int $id;

    #[Groups(["create", "update"])]
    #[OA\Property(type: 'string', maxLength: 255)]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Column(type: "string", length: 255, unique: true, nullable: false)]
    private string $email;

    #[Groups(["create", "update"])]
    #[Assert\NotBlank(groups: ["create"])]
    #[OA\Property(type: 'string', maxLength: 255)]
    #[Column(type: "string", length: 255, nullable: false)]
    private string $password;

    public function getId(): int
    {
        return $this->id;
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