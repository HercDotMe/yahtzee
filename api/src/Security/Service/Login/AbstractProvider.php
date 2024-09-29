<?php

namespace App\Security\Service\Login;

abstract class AbstractProvider
{
    protected readonly string $clientId;
    protected readonly string $clientSecret;
    protected readonly string $redirectUri;

    public function __construct(string $clientId, string $clientSecret, string $redirectUri) {
        $this->redirectUri = $redirectUri;
        $this->clientSecret = $clientSecret;
        $this->clientId = $clientId;
    }
}