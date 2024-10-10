<?php

namespace App\Controller;

use App\DTO\User\UserCreate;
use App\DTO\User\UserUpdate;
use App\Entity\User;
use App\EventListener\SecureRequestListener;
use App\Service\UserManager;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[Route('/user', name: 'user_', options: [SecureRequestListener::APP_SECRET_REQUIRED => true])]
#[OA\Tag('User')]
class UserController extends AbstractController
{
    private UserManager $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    #[Route('/', name: 'create', methods: ['POST'])]
    #[OA\Post(
        description: 'Create a new user',
        summary: 'Create user',
        security: [ [ 'app-secret' => [] ] ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                ref: new Model(type: UserCreate::class, groups: ['create'])
            )
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns the created user',
        content: new OA\JsonContent(
            ref: new Model(type: User::class)
        )
    )]
    public function create(Request $request): JsonResponse
    {
        $userDTO = UserCreate::fromRequest($request);
        return new JsonResponse($this->userManager->createUser($userDTO));
    }

    #[Route('/{id}', name: 'read', methods: ['GET'])]
    #[OA\Get(
        description: 'Read a user',
        summary: 'Read user',
        requestBody: null
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns an existing user',
        content: new OA\JsonContent(
            ref: new Model(type: User::class)
        )
    )]
    public function read(int $id): JsonResponse
    {
        return new JsonResponse($this->userManager->readUser($id));
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    #[OA\Put(
        description: 'Update an existing user',
        summary: 'Update user',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                ref: new Model(type: UserUpdate::class, groups: ['update'])
            )
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns the updated user',
        content: new OA\JsonContent(
            ref: new Model(type: User::class)
        )
    )]
    public function update(int $id, Request $request): JsonResponse
    {
        $userDTO = UserUpdate::fromRequest($request);
        return new JsonResponse($this->userManager->updateUser($id, $userDTO));
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    #[OA\Delete(
        description: 'Delete an existing user',
        summary: 'Delete user',
        requestBody: null
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns the deleted user',
        content: new OA\JsonContent(
            ref: new Model(type: User::class)
        )
    )]
    public function delete(int $id): Response
    {
        $user = $this->userManager->readUser($id);
        $this->userManager->deleteUser($id);

        return new JsonResponse($user);
    }
}
