<?php

namespace App\Controller;

use App\Response\JsonResponse;
use App\Response\Status;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StatusController extends AbstractController
{
    /**
     * Returns the current timestamp
     */
    #[Route('/api/ping', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns the current timestamp',
        content: new OA\JsonContent()
    )]
    #[OA\Tag(name: 'Status checks')]
    public function checkServerIsUp(): JsonResponse
    {
        return new JsonResponse([], Status::SUCCESS);
    }
}