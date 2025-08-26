<?php declare(strict_types=1);

namespace HeyFrame\Core\System\UsageData\Subscriber;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SystemConfig\Event\SystemConfigChangedEvent;
use HeyFrame\Core\System\UsageData\Consent\ConsentService;
use HeyFrame\Core\System\UsageData\Consent\ConsentState;
use HeyFrame\Core\System\UsageData\Services\EntityDispatchService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @internal
 */
#[Package('data-services')]
class UsageDataApprovalSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly EntityDispatchService $entityDispatchService,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SystemConfigChangedEvent::class => 'onDataUsageApprovalChange',
        ];
    }

    public function onDataUsageApprovalChange(SystemConfigChangedEvent $event): void
    {
        if ($event->getKey() !== ConsentService::SYSTEM_CONFIG_KEY_CONSENT_STATE) {
            return;
        }

        if ($event->getValue() !== ConsentState::ACCEPTED->value) {
            return;
        }

        $this->entityDispatchService->dispatchCollectEntityDataMessage();
    }
}
