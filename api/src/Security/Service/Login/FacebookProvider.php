<?php

namespace App\Security\Service\Login;

class FacebookProvider extends AbstractProvider implements LoginProvider
{
    public function __construct(string $clientId, string $clientSecret, string $redirectUri)
    {
        parent::__construct($clientId, $clientSecret, $redirectUri);
    }

    public function getProviderName(): string
    {
        return 'facebook';
    }

    public function getRedirectUrl(): string {
        $params = [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri . $this->getProviderName(),
            'response_type' => 'code',
            'scope' => 'email'
        ];

        return 'https://www.facebook.com/dialog/oauth?' . http_build_query($params);
    }
}