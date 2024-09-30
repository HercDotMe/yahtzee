<?php

namespace App\Security\Controller;

use App\Security\Entity\User;
use App\Security\Service\Login\LoginProvider;
use App\Security\Service\UserManager;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

#[Tag('Security')]
class BridgeController extends AbstractController
{
    /**
     * @var UserManager
     */
    private UserManager $userManager;

    /**
     * @var LoginProvider[]
     */
    private array $loginProviders;

    public function __construct(UserManager $userManager, array $loginProviders)
    {
        $this->userManager = $userManager;

        foreach ($loginProviders as $loginProvider) {
            if ($loginProvider instanceof LoginProvider) {
                $this->loginProviders[$loginProvider->getProviderName()] = $loginProvider;
            }
        }
    }

    #[Route('authorise/{providerName}', name: 'authorise', methods: ['GET'])]
    #[OA\Response(
        response: 302,
        description: "Redirects to the provider's authorization page"
    )]
    #[OA\Parameter(
        name: 'providerName',
        description: 'Name of the provider to use',
        in: 'path',
        required: true,
        allowEmptyValue: false,
        schema: new OA\Schema(
            type: 'string',
            enum: ['facebook', 'twitter', 'google', 'outlook']
        )
    )]
    public function authenticate(
        string $providerName
    ): Response {
        if (isset($this->loginProviders[$providerName])) {
            $callbackURL = $this->generateUrl('api_v1_security_callback', ['providerName' => $providerName]);
            return new RedirectResponse($this->loginProviders[$providerName]->getRedirectUrl($callbackURL));
        }

        return new Response('', Response::HTTP_NOT_FOUND);
    }

    #[Route('callback/{providerName}', name: 'callback', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: "Returns the user associated with the new social provider",
        content: new Model(type: User::class)
    )]
    #[OA\Parameter(
        name: 'providerName',
        description: 'Name of the provider to use',
        in: 'path',
        required: true,
        allowEmptyValue: false,
        schema: new OA\Schema(
            type: 'string',
            enum: ['facebook', 'twitter', 'google', 'outlook']
        )
    )]
    public function callback(string $providerName, Request $request): Response
    {
        $code = $request->query->get('code');
        if (is_string($code) && !empty($code) && isset($this->loginProviders[$providerName])) {
            $selectedProvider = $this->loginProviders[$providerName];
            $callbackURL = $this->generateUrl('api_v1_security_callback', ['providerName' => $providerName]);
            $accessToken = $selectedProvider->getAccessToken($code, $callbackURL);
            $user = $selectedProvider->getUserDetails($accessToken);

            $user = $this->userManager->updateUser($user);

            return new JsonResponse($user, Response::HTTP_OK);
        }

        return new Response('', Response::HTTP_NOT_FOUND);
    }
}
