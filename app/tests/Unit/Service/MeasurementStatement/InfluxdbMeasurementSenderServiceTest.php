<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\MeasurementStatement;

use App\Service\MeasurementSenderService\InfluxdbMeasurementSenderService;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use App\Tests\DataProvider\MeasurementDataProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use InfluxDB2\WriteApi;
use InfluxDB2\Client;

#[CoversClass(InfluxdbMeasurementSenderService::class)]
class InfluxdbMeasurementSenderServiceTest extends TestCase
{
    /**
     * @param  string  $measurement
     * @param  array<string,float|int|numeric-string>  $tags
     * @param  array<string,float|int|numeric-string>  $fields
     * @return void
     * @throws Exception
     */
    #[DataProviderExternal(MeasurementDataProvider::class, 'measurementData')]
    #[TestDox('Sending a measurement should call the write method of the InfluxDB client with the correct parameters')]
    public function testSendMeasurement(string $measurement, array $tags, array $fields): void
    {
        $writeApiMock = $this->createMock(WriteApi::class);
        $writeApiMock->expects(self::once())->method('write');

        $influxdbMock = $this->createMock(Client::class);
        $influxdbMock->expects(self::once())->method('createWriteApi')->willReturn($writeApiMock);

        $measureSenderService = new InfluxdbMeasurementSenderService($influxdbMock, 'bucket', 'organization');

        $measureSenderService->sendMeasurement($measurement, $tags, $fields);
    }
}
