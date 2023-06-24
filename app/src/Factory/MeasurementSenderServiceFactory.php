<?php

declare(strict_types=1);

namespace App\Factory;

use Countable;
use IteratorAggregate;
use App\Interface\MeasurementSenderInterface;
use App\Interface\ServiceClassProviderInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class MeasurementSenderServiceFactory
{
    /**
     * @var IteratorAggregate<MeasurementSenderInterface>&Countable
     */
    readonly private IteratorAggregate&Countable $measurementSenderServices;

    public function __construct(
        #[TaggedIterator('measurementSender')] IteratorAggregate&Countable $measurementSenderServices
    ) {
        $this->measurementSenderServices = $measurementSenderServices;
    }

    public function getMeasurementSenderService(ServiceClassProviderInterface $sender): ?MeasurementSenderInterface
    {
        $senderClass = $sender->getClass();
        foreach ($this->measurementSenderServices as $service) {
            if ($senderClass === $service::class) {
                return $service;
            }
        }
        return null;
    }
}
