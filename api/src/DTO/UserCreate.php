<?php

namespace App\DTO;

use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

class UserCreate
{
    #[OA\Property(type: "string", maxLength: 255)]
    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

    #[OA\Property(type: "string", maxLength: 255)]
    #[Assert\NotBlank]
    public string $password;
}