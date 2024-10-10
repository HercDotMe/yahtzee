<?php

namespace App\DTO\User;

use Symfony\Component\HttpFoundation\Request;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

readonly class UserCreate extends UserUpdate
{
    #[Groups(['create'])]
    #[Assert\NotBlank(groups: ['create'])]
    #[Assert\Email(groups: ['create'])]
    #[Assert\IdenticalTo(propertyPath: 'email', groups: ['create'])]
    #[OA\Property(type: 'string', format: 'email')]
    public ?string $emailConfirm;

    #[Groups(['create'])]
    #[Assert\NotBlank(groups: ['create'])]
    #[Assert\IdenticalTo(propertyPath: 'password', groups: ['create'])]
    #[OA\Property(type: 'string', format: 'password')]
    public ?string $passwordConfirm;

    public function __construct(?string $email, ?string $emailConfirm, ?string $password, ?string $passwordConfirm)
    {
        parent::__construct($email, $password);

        $this->emailConfirm = $emailConfirm;
        $this->passwordConfirm = $passwordConfirm;
    }

    public static function fromRequest(Request $request): self
    {
        $requestContent = json_decode($request->getContent(), true);
        return new self($requestContent['email'] ?? null, $requestContent['emailConfirm'] ?? null, $requestContent['password'] ?? null, $requestContent['passwordConfirm'] ?? null);
    }
}
