<?php

declare(strict_types=1);

namespace App\Interface;

interface MeasurementSenderInterface
{
    /**
     * @param  string  $measurement
     * @param  array<string, mixed>  $tags
     * @param  array<string, numeric>  $fields
     * @return void
     */
    public function sendMeasurement(string $measurement, array $tags = [], array $fields = []): void;
}
