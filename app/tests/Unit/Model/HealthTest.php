<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model;

use App\Enum\HealthStatus;
use App\Model\Health;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

#[CoversClass(Health::class)]
class HealthTest extends TestCase
{
    #[TestDox('It should initialize a Health object with default values')]
    public function testConstructor(): void
    {
        $health = new Health();

        self::assertInstanceOf(Health::class, $health);
        self::assertInstanceOf(Uuid::class, $health->flowId);
        self::assertSame(HealthStatus::OK, $health->status);
    }
}
