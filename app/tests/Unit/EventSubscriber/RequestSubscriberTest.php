<?php

declare(strict_types=1);

namespace App\Tests\Unit\EventSubscriber;

use App\EventSubscriber\RequestSubscriber;
use App\Factory\MeasurementSenderServiceFactory;
use App\Interface\MeasurementSenderInterface;
use App\Interface\ServiceClassProviderInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

#[CoversClass(RequestSubscriber::class)]
class RequestSubscriberTest extends TestCase
{
    #[TestDox('getSubscribedEvents returns expected events')]
    public function testGetSubscribedEventsReturnsExpectedEvents(): void
    {
        $expectedEvents = [KernelEvents::REQUEST => 'onKernelRequest'];

        self::assertSame($expectedEvents, RequestSubscriber::getSubscribedEvents());
    }

    #[TestDox('onKernelRequest sends measurement with expected data')]
    public function testOnKernelRequestSendsMeasurementWithExpectedData(): void
    {
        $requestMock = $this->createMock(Request::class);
        $requestMock->expects(self::once())->method("isSecure")->willReturn(true);
        $requestMock->expects(self::once())->method("getLocale")->willReturn('en');
        $requestMock->expects(self::once())->method("getMethod")->willReturn('GET');
        $requestMock->expects(self::once())->method("getClientIp")->willReturn('128.0.0.1');
        $requestMock->attributes = $this->createMock(ParameterBag::class);
        $requestMock->attributes->expects(self::once())->method('get')->with('_route')->willReturn('index');
        $requestMock->headers = $this->createMock(HeaderBag::class);
        $requestMock->headers->expects(self::once())->method('get')->with('User-Agent')->willReturn('Chrome');

        $requestEventMock = $this->createMock(RequestEvent::class);
        $requestEventMock->method('getRequest')->willReturn($requestMock);

        $measurementSenderServiceMock = $this->createMock(MeasurementSenderInterface::class);
        $measurementSenderServiceMock->expects(self::once())->method('sendMeasurement');

        $measurementSenderServiceFactoryMock = $this->createMock(MeasurementSenderServiceFactory::class);
        $measurementSenderServiceFactoryMock->expects(self::once())->method('getMeasurementSenderService')->willReturn(
            $measurementSenderServiceMock
        );

        $measurementSenderServiceNameMock = $this->createMock(ServiceClassProviderInterface::class);

        $subscriber = new RequestSubscriber($measurementSenderServiceFactoryMock, $measurementSenderServiceNameMock);
        $subscriber->onKernelRequest($requestEventMock);
    }
}
