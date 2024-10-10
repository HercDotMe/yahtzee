<?php

namespace App\DTO\User;

use Symfony\Component\HttpFoundation\Request;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

readonly class UserUpdate
{
    #[Groups(['create', 'update'])]
    #[Assert\NotBlank(groups: ['create'])]
    #[Assert\Email(groups: ['create'])]
    #[OA\Property(type: 'string', format: 'email', nullable: true)]
    public ?string $email;

    #[Groups(['create', 'update'])]
    #[Assert\NotBlank(groups: ['create'])]
    #[OA\Property(type: 'string', format: 'password', nullable: true)]
    public ?string $password;

    public function __construct(?string $email, ?string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public static function fromRequest(Request $request): self
    {
        $requestContent = json_decode($request->getContent(), true);
        return new self($requestContent['email'] ?? null, $requestContent['password'] ?? null);
    }
}
