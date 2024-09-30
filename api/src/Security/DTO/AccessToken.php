<?php

namespace App\Security\DTO;

use DateTime;

readonly class AccessToken
{
    public string $token;

    public string $type;

    public DateTime $expires;

    public function __construct(string $token, string $type, DateTime $expires)
    {
        $this->token = $token;
        $this->type = $type;
        $this->expires = $expires;
    }
}
