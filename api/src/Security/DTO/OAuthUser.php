<?php

namespace App\Security\DTO;

readonly class OAuthUser
{
    public string $providerName;
    public string $userID;
    public string $userEmail;
    public AccessToken $accessToken;

    public function __construct(string $providerName, string $userID, string $userEmail, AccessToken $accessToken)
    {
        $this->providerName = $providerName;
        $this->userID = $userID;
        $this->userEmail = $userEmail;
        $this->accessToken = $accessToken;
    }
}