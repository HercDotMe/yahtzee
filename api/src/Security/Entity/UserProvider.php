<?php

namespace App\Security\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;

#[ORM\Entity]
#[ORM\Index(columns: ['provider_user_id', 'provider_name'])]
class UserProvider extends Timestampable
{
    #[OA\Property(type: 'integer', readOnly: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public int $id;

    #[ORM\ManyToOne(targetEntity: User::class)]
    public User $user;

    #[OA\Property(type: 'string', readOnly: true)]
    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    public string $providerName;

    #[OA\Property(type: 'string', readOnly: true)]
    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    public string $providerUserId;

    #[OA\Property(type: 'string', readOnly: true)]
    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    public string $tokenValue;

    #[OA\Property(type: 'datetime', readOnly: true)]
    #[ORM\Column(type: 'datetime', nullable: false)]
    public DateTime $tokenExpiry;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): UserProvider
    {
        $this->user = $user;
        return $this;
    }

    public function getProviderName(): string
    {
        return $this->providerName;
    }

    public function setProviderName(string $providerName): UserProvider
    {
        $this->providerName = $providerName;
        return $this;
    }

    public function getProviderUserId(): string
    {
        return $this->providerUserId;
    }

    public function setProviderUserId(string $providerUserId): UserProvider
    {
        $this->providerUserId = $providerUserId;
        return $this;
    }

    public function getTokenValue(): string
    {
        return $this->tokenValue;
    }

    public function setTokenValue(string $tokenValue): UserProvider
    {
        $this->tokenValue = $tokenValue;
        return $this;
    }

    public function getTokenExpiry(): DateTime
    {
        return $this->tokenExpiry;
    }

    public function setTokenExpiry(DateTime $tokenExpiry): UserProvider
    {
        $this->tokenExpiry = $tokenExpiry;
        return $this;
    }
}
