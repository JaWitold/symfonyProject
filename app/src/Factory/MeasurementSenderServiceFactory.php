<?php

declare(strict_types=1);

namespace App\Factory;

use App\Interface\MeasurementSenderInterface;
use App\Interface\ServiceClassProviderInterface;
use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class MeasurementSenderServiceFactory
{
    /**
     * @var RewindableGenerator<MeasurementSenderInterface>
     */
    readonly private RewindableGenerator $measurementSenderServices;

    public function __construct(
        #[TaggedIterator('measurementSender')] RewindableGenerator $measurementSenderServices
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
