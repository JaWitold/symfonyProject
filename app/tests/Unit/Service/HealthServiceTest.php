<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Model\Health;
use App\Service\HealthService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(HealthService::class)]
class HealthServiceTest extends TestCase
{
    #[TestDox('It should return a Health object')]
    public function testInvoke(): void
    {
        $healthService = new HealthService();

        self::assertInstanceOf(Health::class, $healthService());
    }
}
