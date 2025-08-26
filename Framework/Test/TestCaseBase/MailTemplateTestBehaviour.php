<?php declare(strict_types=1);

namespace HeyFrame\Core\Framework\Test\TestCaseBase;

use PHPUnit\Framework\TestCase;
use HeyFrame\Core\Framework\Event\EventData\MailRecipientStruct;
use HeyFrame\Core\Framework\Event\MailAware;
use HeyFrame\Core\Framework\Event\HeyFrameEvent;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Contracts\EventDispatcher\Event;

trait MailTemplateTestBehaviour
{
    use EventDispatcherBehaviour;

    /**
     * @param class-string<object> $expectedClass
     */
    public static function assertMailEvent(
        string $expectedClass,
        HeyFrameEvent $event,
        SalesChannelContext $salesChannelContext
    ): void {
        TestCase::assertInstanceOf($expectedClass, $event);
        TestCase::assertSame($salesChannelContext->getContext(), $event->getContext());
    }

    public static function assertMailRecipientStructEvent(MailRecipientStruct $expectedStruct, MailAware $event): void
    {
        TestCase::assertSame($expectedStruct->getRecipients(), $event->getMailStruct()->getRecipients());
    }

    /**
     * @template TEvent of Event
     *
     * @param class-string<TEvent> $eventName
     * @param TEvent|null $eventResult
     */
    protected function catchEvent(string $eventName, ?object &$eventResult): void
    {
        $eventDispatcher = static::getContainer()->get('event_dispatcher');
        $this->addEventListener($eventDispatcher, $eventName, static function ($event) use (&$eventResult): void {
            $eventResult = $event;
        });
    }
}
