<?php

namespace App\Security\Service\Login;

interface LoginProvider
{
    public function getProviderName() : string;

    public function getRedirectUrl(): string;
}