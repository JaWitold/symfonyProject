<?php

declare(strict_types=1);

namespace App\Service\MeasurementSenderService;

use App\Interface\MeasurementSenderInterface;
use League\StatsD\Client;

readonly class GraphiteMeasurementSenderService implements MeasurementSenderInterface
{
    /**
     * @param  Client  $graphite
     * @param  array<string, string>  $options
     */
    public function __construct(private Client $graphite, private array $options)
    {
    }

    public function sendMeasurement(string $measurement, array $tags = [], array $fields = []): void
    {
        $this->graphite->configure(
            ['throwConnectionExceptions' => false, ...$this->options, 'namespace' => $measurement]
        );
        $values = array_map(
            fn($element) => preg_replace(
                '/_+/',
                '_',
                str_replace(['.', ' ', '/', ';'], '_', print_r($element, true))
            ),
            $tags
        );
        $values = array_map(fn($key, $value) => $key . '.' . $value, array_keys($values), $values);
        $this->graphite->increment($values, (int)($fields['value'] ?? 1));
    }
}
