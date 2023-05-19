<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller;

use App\Controller\ActuatorController;
use App\Model\Health;
use App\Service\HealthService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

#[CoversClass(ActuatorController::class)]
class ActuatorControllerTest extends TestCase
{
    #[TestDox('It should return the health model as a JSON response')]
    public function testIndex(): void
    {
        $healthModelMock = new Health();
        $healthServiceMock = $this->createMock(HealthService::class);
        $healthServiceMock->expects(self::once())->method('__invoke')->willReturn($healthModelMock);

        $controller = new ActuatorController();
        $response = $controller->health($healthServiceMock);

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals(json_encode($healthModelMock), $response->getContent());
    }
}
