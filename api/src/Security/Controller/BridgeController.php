<?php

namespace App\Security\Controller;

use App\Security\Service\Login\LoginProvider;
use OpenApi\Attributes\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Tag('Security')]
class BridgeController extends AbstractController
{
    /**
     * @var LoginProvider[]
     */
    private array $loginProviders;

    public function __construct(array $loginProviders)
    {
        foreach ($loginProviders as $loginProvider) {
            if ($loginProvider instanceof LoginProvider)
            {
                $this->loginProviders[$loginProvider->getProviderName()] = $loginProvider;
            }
        }
    }

    #[Route('authorise/{providerName}', name: 'authorise', methods: ['GET'])]
    public function authenticate($providerName): Response
    {
        if (isset($this->loginProviders[$providerName])) {
            return new RedirectResponse($this->loginProviders[$providerName]->getRedirectUrl());
        }

        return new Response('', Response::HTTP_NOT_FOUND);
    }
}