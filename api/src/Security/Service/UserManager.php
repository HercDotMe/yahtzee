<?php

namespace App\Security\Service;

use App\Security\DTO\OAuthUser;
use App\Security\Entity\User;
use App\Security\Entity\UserProvider;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class UserManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function updateUser(OAuthUser $user): User
    {
        // Try and fetch existing entries
        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $user->userEmail]);
        $existingUserProvider = $this->entityManager->getRepository(UserProvider::class)->findOneBy([
            'providerName' => $user->providerName,
            'providerUserId' => $user->userID
        ]);

        // Update or create user
        if ($existingUser === null) {
            $existingUser = new User();
            $existingUser->setCreatedAt(new DateTime());
            $existingUser->setNickname(null);
        }
        $existingUser->setEmail($user->userEmail);
        $existingUser->setUpdatedAt(new DateTime());

        // Update or create user provider
        if ($existingUserProvider === null) {
            $existingUserProvider = new UserProvider();
            $existingUserProvider->setCreatedAt(new DateTime());
        }
        $existingUserProvider->setUser($existingUser);
        $existingUserProvider->setProviderName($user->providerName);
        $existingUserProvider->setProviderUserId($user->userID);
        $existingUserProvider->setTokenValue($user->accessToken->token);
        $existingUserProvider->setTokenExpiry($user->accessToken->expires);
        $existingUserProvider->setUpdatedAt(new DateTime());

        // Save updated entities
        $this->entityManager->persist($existingUser);
        $this->entityManager->persist($existingUserProvider);
        $this->entityManager->flush();

        // Return user
        return $existingUser;
    }
}
