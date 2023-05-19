<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\MeasurementStatement;

use App\Service\MeasurementSenderService\GraphiteMeasurementSenderService;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use App\Tests\DataProvider\MeasurementDataProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use League\StatsD\Client;

#[CoversClass(GraphiteMeasurementSenderService::class)]
class GraphiteMeasurementSenderServiceTest extends TestCase
{
    /**
     * @param  string  $measurement
     * @param  array<string,float|int|numeric-string>  $tags
     * @param  array<string,float|int|numeric-string>  $fields
     * @return void
     * @throws Exception
     */
    #[DataProviderExternal(MeasurementDataProvider::class, 'measurementData')]
    #[TestDox("sendMeasurement sends the measurement with the provided data using GraphiteMeasureSenderService")]
    public function testSendMeasurement(string $measurement, array $tags, array $fields): void
    {
        $graphiteMock = $this->createMock(Client::class);
        $graphiteMock->expects(self::once())->method('configure');
        $graphiteMock->expects(self::once())->method('increment');

        $measureSenderService = new GraphiteMeasurementSenderService($graphiteMock, [
            'host' => 'mockHost',
            'port' => 'mockPort',
            'namespace' => "mockNamespace",
        ]);

        $measureSenderService->sendMeasurement($measurement, $tags, $fields);
    }
}
