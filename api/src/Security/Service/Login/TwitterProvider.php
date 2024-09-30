<?php

namespace App\Security\Service\Login;

use App\Security\DTO\AccessToken;
use App\Security\DTO\OAuthUser;

class TwitterProvider extends AbstractProvider implements LoginProvider
{
    public function getProviderName(): string
    {
        return 'twitter';
    }

    public function getRedirectUrl(string $callbackURL): string
    {
        $params = [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->appURL . $callbackURL,
            'response_type' => 'code',
            'scope' => 'email'
        ];

        return 'https://www.facebook.com/dialog/oauth?' . http_build_query($params);
    }

    public function getAccessToken(string $code, string $callbackURL): AccessToken
    {
        return new AccessToken();
    }

    public function getUserDetails(AccessToken $accessToken): OAuthUser
    {
        return new OAuthUser();
    }
}
