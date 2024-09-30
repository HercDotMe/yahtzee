<?php

namespace App\Security\Service\Login;

use App\Security\DTO\AccessToken;
use App\Security\DTO\OAuthUser;

interface LoginProvider
{
    public function getProviderName() : string;

    public function getRedirectUrl(string $callbackURL): string;

    public function getAccessToken(string $code, string $callbackURL): AccessToken;

    public function getUserDetails(AccessToken $accessToken): OAuthUser;
}