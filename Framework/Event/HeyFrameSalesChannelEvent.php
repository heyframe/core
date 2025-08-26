<?php declare(strict_types=1);

namespace HeyFrame\Core\Framework\Event;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('framework')]
interface HeyFrameSalesChannelEvent extends HeyFrameEvent
{
    public function getSalesChannelContext(): SalesChannelContext;
}
