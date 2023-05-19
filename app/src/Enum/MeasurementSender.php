<?php

declare(strict_types=1);

namespace App\Enum;

use App\Interface\ServiceClassProviderInterface;
use App\Service\MeasurementSenderService\DefaultMeasurementSenderService;
use App\Service\MeasurementSenderService\GraphiteMeasurementSenderService;
use App\Service\MeasurementSenderService\InfluxdbMeasurementSenderService;

enum MeasurementSender: string implements ServiceClassProviderInterface
{
    case Influxdb = "Influxdb";
    case Graphite = "Graphite";
    case Default = "Default";

    public function getClass(): string
    {
        return match ($this) {
            self::Influxdb => InfluxdbMeasurementSenderService::class,
            self::Graphite => GraphiteMeasurementSenderService::class,
            self::Default => DefaultMeasurementSenderService::class,
        };
    }
}
