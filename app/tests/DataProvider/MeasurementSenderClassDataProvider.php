<?php

declare(strict_types=1);

namespace App\Tests\DataProvider;

use App\Enum\MeasurementSender;
use App\Service\MeasurementSenderService\GraphiteMeasurementSenderService;
use App\Service\MeasurementSenderService\InfluxdbMeasurementSenderService;

enum MeasurementSenderClassDataProvider
{
    /**
     * @return array<string, array<string, MeasurementSender|string>>
     */
    public static function getCases(): array
    {
        return [
            MeasurementSender::Influxdb->value => [
                'sender' => MeasurementSender::Influxdb,
                'expectedClass' => InfluxdbMeasurementSenderService::class,
            ],
            MeasurementSender::Graphite->value => [
                'sender' => MeasurementSender::Graphite,
                'expectedClass' => GraphiteMeasurementSenderService::class,
            ],
        ];
    }
}
