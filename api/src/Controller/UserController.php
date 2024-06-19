<?php

namespace App\Controller;

use App\Entity\User;
use App\Response\JsonResponse;
use App\Response\Status;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Logs in the provided user
     */
    #[Route('/api/login', methods: ['POST'])]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            ref: new Model(type: User::class, groups: ['login'])
        )
    )]
    #[OA\Tag(name: 'User endpoints')]
    public function login(Request $request): JsonResponse
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $request->get('email')]);
        if ($user === null) {
            return new JsonResponse('User not found!', Status::BAD_REQUEST);
        }

        return new JsonResponse([], Status::SUCCESS);
    }
}