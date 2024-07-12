<?php

namespace App\DTO;

use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

class UserUpdate
{
    #[OA\Property(type: "string", maxLength: 255)]
    #[Assert\Email]
    public string $email;

    #[OA\Property(type: "string", maxLength: 255)]
    public string $password;
}