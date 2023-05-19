<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\MeasurementStatement;

use App\Service\MeasurementSenderService\DefaultMeasurementSenderService;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use App\Tests\DataProvider\MeasurementDataProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

#[CoversClass(DefaultMeasurementSenderService::class)]
class DefaultMeasurementSenderServiceTest extends TestCase
{
    /**
     * @param  string  $measurement
     * @param  array<string,float|int|numeric-string>  $tags
     * @param  array<string,float|int|numeric-string>  $fields
     * @return void
     * @throws Exception
     */
    #[DataProviderExternal(MeasurementDataProvider::class, 'measurementData')]
    #[TestDox("sendMeasurement writes to log the measurement with the provided data")]
    public function testSendMeasurement(string $measurement, array $tags, array $fields): void
    {
        $loggerMock = $this->createMock(LoggerInterface::class);
        $loggerMock->expects(self::once())->method('debug');

        $measureSenderService = new DefaultMeasurementSenderService($loggerMock);

        $measureSenderService->sendMeasurement($measurement, $tags, $fields);
    }
}
