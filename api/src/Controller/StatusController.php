<?php

namespace App\Controller;

use App\Response\JsonResponse;
use App\Response\Status;
use OpenApi\Attributes as OA;
use Symfony\Component\Routing\Annotation\Route;

class StatusController
{
    /**
     * List the rewards of the specified user.
     *
     * This call takes into account all confirmed awards, but not pending or refused awards.
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