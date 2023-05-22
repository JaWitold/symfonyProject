<?php

declare(strict_types=1);

namespace App\Service\MeasurementSenderService;

use App\Interface\MeasurementSenderInterface;
use DateTimeImmutable;
use DateTimeInterface;
use Psr\Log\LoggerInterface;

readonly class DefaultMeasurementSenderService implements MeasurementSenderInterface
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function sendMeasurement(string $measurement, array $tags = [], array $fields = []): void
    {
        $point = [
            'name' => $measurement,
            'tags' => $tags,
            'fields' => $fields,
        ];
        $date = (new DateTimeImmutable())->format(DateTimeInterface::ISO8601_EXPANDED);
        $this->logger->debug($date . ' adding measurement. ' . json_encode($point));
    }
}
