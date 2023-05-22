<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Health;
use App\Service\HealthService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class ActuatorController extends AbstractController
{
    #[Route('/api/health', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Successful response',
        content: new Model(type: Health::class),
    )]
    #[OA\Tag(name: 'health')]
    public function health(HealthService $healthService): JsonResponse
    {
        return new JsonResponse($healthService());
    }
}
