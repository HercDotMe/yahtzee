<?php

namespace App\Security\Service\Login;

abstract class AbstractProvider
{
    protected readonly string $clientId;
    protected readonly string $clientSecret;
    protected readonly string $appURL;

    public function __construct(string $clientId, string $clientSecret, string $appURL)
    {
        $this->appURL = $appURL;
        $this->clientSecret = $clientSecret;
        $this->clientId = $clientId;
    }
}
