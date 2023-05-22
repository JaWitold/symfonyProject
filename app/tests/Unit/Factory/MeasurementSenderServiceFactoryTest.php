<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Factory\MeasurementSenderServiceFactory;
use App\Interface\MeasurementSenderInterface;
use App\Interface\ServiceClassProviderInterface;
use App\Service\MeasurementSenderService\InfluxdbMeasurementSenderService;
use InfluxDB2\Client;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

#[CoversClass(MeasurementSenderServiceFactory::class)]
class MeasurementSenderServiceFactoryTest extends TestCase
{
    private ServiceClassProviderInterface $senderMock;
    private Client $influxdbMock;

    protected function setUp(): void
    {
        $this->senderMock = $this->createMock(ServiceClassProviderInterface::class);
        $this->senderMock->method('getClass')->willReturn(InfluxdbMeasurementSenderService::class);
        $this->influxdbMock = $this->createMock(Client::class);
    }

    #[TestDox('getMeasurementSenderService returns matching service')]
    public function testGetMeasurementSenderServiceReturnsMatchingService(): void
    {
        $measureSenderService = new InfluxdbMeasurementSenderService($this->influxdbMock, 'bucket', 'org');

        $generator = function () use ($measureSenderService) {
            yield $measureSenderService;
        };

        $measurementSenderServices = new RewindableGenerator($generator, 1);

        $factory = new MeasurementSenderServiceFactory($measurementSenderServices);
        $result = $factory->getMeasurementSenderService($this->senderMock);
        self::assertSame($measureSenderService, $result);
    }

    #[TestDox('getMeasurementSenderService returns null if no matching service')]
    public function testGetMeasurementSenderServiceReturnsNullIfNoMatchingService(): void
    {
        $generator = function () {
            yield new class implements MeasurementSenderInterface {
                public function sendMeasurement(string $measurement, array $tags = [], array $fields = []): void
                {
                }
            };
        };

        $measurementSenderServices = new RewindableGenerator($generator, 1);

        $factory = new MeasurementSenderServiceFactory($measurementSenderServices);
        $result = $factory->getMeasurementSenderService($this->senderMock);
        self::assertNull($result);
    }
}
