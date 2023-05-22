<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Factory\MeasurementSenderServiceFactory;
use App\Interface\ServiceClassProviderInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

readonly class RequestSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private MeasurementSenderServiceFactory $measurementSenderServiceFactory,
        private ServiceClassProviderInterface $measurementSenderServiceName
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest'
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        /** @var array<string> $tags */
        $tags = [
            'protocol' => 'http' . ($request->isSecure() ? 's' : ''),
            'locale' => $request->getLocale(),
            'method' => $request->getMethod(),
            'ip_address' => $request->getClientIp(),
            'route' => $request->attributes->get('_route'),
            'user_agent' => $request->headers->get('User-Agent'),
        ];

        $measureSenderService = $this->measurementSenderServiceFactory->getMeasurementSenderService(
            $this->measurementSenderServiceName
        );
        $measureSenderService?->sendMeasurement('route', $tags, ['value' => 1]);
    }
}
