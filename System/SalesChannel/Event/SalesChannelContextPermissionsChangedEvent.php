<?php declare(strict_types=1);

namespace HeyFrame\Core\System\SalesChannel\Event;

use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\Event\NestedEvent;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('framework')]
class SalesChannelContextPermissionsChangedEvent extends NestedEvent implements HeyFrameSalesChannelEvent
{
    /**
     * @param array<string, bool> $permissions
     */
    public function __construct(
        private readonly SalesChannelContext $salesChannelContext,
        protected array $permissions = []
    ) {
    }

    public function getContext(): Context
    {
        return $this->salesChannelContext->getContext();
    }

    public function getSalesChannelContext(): SalesChannelContext
    {
        return $this->salesChannelContext;
    }

    /**
     * @return array<string, bool>
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }
}
