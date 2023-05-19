<?php

declare(strict_types=1);

namespace App\Tests\DataProvider;

class MeasurementDataProvider
{
    /**
     * @return array<string, array<string, array<string, int|string>|string>>
     */
    public static function measurementData(): array
    {
        return [
            'measurementMock' => [
                'measurement' => 'measurement',
                'tags' => ['tag1' => 'value1', 'tag2' => 'value2'],
                'fields' => ['field1' => 123, 'field2' => 'abc'],
            ],
        ];
    }
}
