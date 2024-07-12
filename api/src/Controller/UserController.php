<?php

namespace App\Controller;

use App\DTO\UserCreate;
use App\DTO\UserUpdate;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Returns an existing user
     */
    #[Route('/api/user/{id}', methods: ['GET'])]
    #[OA\RequestBody(
        required: false
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns the user',
        content: new Model(type: User::class)
    )]
    #[OA\Tag(name: 'User endpoints')]
    public function read($id): JsonResponse
    {
        return new JsonResponse($id);
    }

    /**
     * Registers a new user
     */
    #[Route('/api/user', methods: ['POST'])]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            ref: new Model(type: UserCreate::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns the user',
        content: new Model(type: User::class)
    )]
    #[OA\Tag(name: 'User endpoints')]
    public function create(#[MapRequestPayload] UserCreate $dto): JsonResponse
    {
        return new JsonResponse($dto);
    }

    /**
     * Updates an existing new user
     */
    #[Route('/api/user/{id}', methods: ['PATCH'])]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            ref: new Model(type: UserUpdate::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns the user',
        content: new Model(type: User::class)
    )]
    #[OA\Tag(name: 'User endpoints')]
    public function update(#[MapRequestPayload] UserUpdate $dto): JsonResponse
    {
        return new JsonResponse($dto);
    }

    /**
     * Updates an existing new user
     */
    #[Route('/api/user/{id}', methods: ['DELETE'])]
    #[OA\RequestBody(
        required: false
    )]
    #[OA\Response(
        response: 204,
        description: 'Returns no content'
    )]
    #[OA\Tag(name: 'User endpoints')]
    public function delete($id): JsonResponse
    {
        return new JsonResponse([], 204);
    }
}