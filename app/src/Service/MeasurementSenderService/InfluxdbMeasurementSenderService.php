<?php

declare(strict_types=1);

namespace App\Service\MeasurementSenderService;

use App\Interface\MeasurementSenderInterface;
use InfluxDB2\Client;
use InfluxDB2\Model\WritePrecision;

readonly class InfluxdbMeasurementSenderService implements MeasurementSenderInterface
{
    public function __construct(
        private Client $influxdb,
        private ?string $bucket,
        private ?string $organization,
        private string $precision = WritePrecision::MS,
    ) {
    }

    public function sendMeasurement(string $measurement, array $tags = [], array $fields = []): void
    {
        $point = [
            'name' => $measurement,
            'tags' => $tags,
            'fields' => $fields,
        ];

        $writeApi = $this->influxdb->createWriteApi();
        $writeApi->write($point, $this->precision, $this->bucket, $this->organization);
    }

    public function __destruct()
    {
        $this->influxdb->close();
    }
}
