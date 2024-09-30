<?php

namespace App\Security\Controller;

use App\Security\Service\Login\LoginProvider;
use OpenApi\Attributes\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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
    public function authenticate(string $providerName): Response
    {
        if (isset($this->loginProviders[$providerName])) {
            $callbackURL = $this->generateUrl('api_v1_security_callback', ['providerName' => $providerName]);
            return new RedirectResponse($this->loginProviders[$providerName]->getRedirectUrl($callbackURL));
        }

        return new Response('', Response::HTTP_NOT_FOUND);
    }

    #[Route('callback/{providerName}', name: 'callback', methods: ['GET'])]
    public function callback(string $providerName, Request $request): Response
    {
        $code = $request->query->get('code');
        if (is_string($code) && !empty($code) && isset($this->loginProviders[$providerName])) {
            $selectedProvider = $this->loginProviders[$providerName];
            $callbackURL = $this->generateUrl('api_v1_security_callback', ['providerName' => $providerName]);
            $accessToken = $selectedProvider->getAccessToken($code, $callbackURL);
            $user = $selectedProvider->getUserDetails($accessToken);

            return new JsonResponse($user, Response::HTTP_OK);
        }

        return new Response('', Response::HTTP_NOT_FOUND);
    }
}