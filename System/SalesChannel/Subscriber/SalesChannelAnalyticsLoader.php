<?php declare(strict_types=1);

namespace HeyFrame\Core\System\SalesChannel\Subscriber;

use HeyFrame\Core\Framework\DataAbstractionLayer\EntityRepository;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\Aggregate\SalesChannelAnalytics\SalesChannelAnalyticsCollection;
use HeyFrame\Storefront\Event\StorefrontRenderEvent;

/**
 * @internal
 */
#[Package('discovery')]
class SalesChannelAnalyticsLoader
{
    /**
     * @param EntityRepository<SalesChannelAnalyticsCollection> $salesChannelAnalyticsRepository
     */
    public function __construct(
        private readonly EntityRepository $salesChannelAnalyticsRepository,
    ) {
    }

    public function loadAnalytics(StorefrontRenderEvent $event): void
    {
        $salesChannelContext = $event->getSalesChannelContext();
        $salesChannel = $salesChannelContext->getSalesChannel();
        $analyticsId = $salesChannel->getAnalyticsId();

        if (empty($analyticsId)) {
            return;
        }

        $criteria = new Criteria([$analyticsId]);
        $criteria->setTitle('sales-channel::load-analytics');

        $analytics = $this->salesChannelAnalyticsRepository->search($criteria, $salesChannelContext->getContext())->getEntities()->first();

        $event->setParameter('storefrontAnalytics', $analytics);
    }
}
