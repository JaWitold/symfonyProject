<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\HealthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ActuatorController extends AbstractController
{
    #[Route('/health', name: 'health')]
    public function index(HealthService $healthService): JsonResponse
    {
        return new JsonResponse($healthService());
    }
}
