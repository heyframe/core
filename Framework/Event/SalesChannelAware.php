<?php declare(strict_types=1);

namespace HeyFrame\Core\Framework\Event;

use HeyFrame\Core\Framework\Log\Package;

#[Package('fundamentals@after-sales')]
#[IsFlowEventAware]
interface SalesChannelAware
{
    public function getSalesChannelId(): string;
}
