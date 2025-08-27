<?php declare(strict_types=1);

namespace HeyFrame\Core\System\UsageData\ScheduledTask;

use HeyFrame\Core\Framework\DataAbstractionLayer\EntityRepository;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskCollection;
use HeyFrame\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskHandler;
use HeyFrame\Core\System\UsageData\Services\EntityDispatchService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * @internal
 */
#[Package('data-services')]
#[AsMessageHandler(handles: CollectEntityDataTask::class)]
final class CollectEntityDataTaskHandler extends ScheduledTaskHandler
{
    /**
     * @param EntityRepository<ScheduledTaskCollection> $repository
     */
    public function __construct(
        EntityRepository $repository,
        LoggerInterface $logger,
        private readonly EntityDispatchService $entityDispatchService,
    ) {
        parent::__construct($repository, $logger);
    }

    public function run(): void
    {
        $this->entityDispatchService->dispatchCollectEntityDataMessage();
    }
}
