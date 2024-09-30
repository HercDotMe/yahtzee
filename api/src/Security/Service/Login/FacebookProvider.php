<?php

namespace App\Security\Service\Login;

use App\Security\DTO\AccessToken;
use App\Security\DTO\OAuthUser;
use DateInterval;
use DateTime;

class FacebookProvider extends AbstractProvider implements LoginProvider
{
    public function getProviderName(): string
    {
        return 'facebook';
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
        $params = [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->appURL . $callbackURL,
            'code' => $code
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => "https://graph.facebook.com/oauth/access_token",
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => http_build_query($params),
        ]);

        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);

        return new AccessToken($response['access_token'], $response['token_type'], (new DateTime())->add(new DateInterval('PT' . $response['expires_in'] . 'S')));
    }

    public function getUserDetails(AccessToken $accessToken): OAuthUser
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://graph.facebook.com/me?fields=id,email',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $accessToken->token
            ]
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);

        return new OAuthUser(
            $this->getProviderName(),
            $response['id'],
            $response['email'],
            $accessToken
        );
    }
}
