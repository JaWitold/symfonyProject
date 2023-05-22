<?php

declare(strict_types=1);

namespace App\Tests\Unit\Enum;

use App\Tests\DataProvider\MeasurementSenderClassDataProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\CoversClass;
use App\Enum\MeasurementSender;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(MeasurementSender::class)]
class MeasurementSenderTest extends TestCase
{
    #[DataProviderExternal(MeasurementSenderClassDataProvider::class, 'getCases')]
    #[TestDox('MeasurementSender::getClass returns expected class')]
    public function testMeasurementSenderGetClassReturnsExpectedClass(
        MeasurementSender $sender,
        string $expectedClass
    ): void {
        self::assertSame($expectedClass, $sender->getClass());
    }
}
