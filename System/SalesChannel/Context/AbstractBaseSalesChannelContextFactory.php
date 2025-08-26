<?php declare(strict_types=1);

namespace HeyFrame\Core\System\SalesChannel\Context;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\BaseSalesChannelContext;

/**
 * Loads customer-independent information for a sales channel, which could be cached separately.
 *
 * @internal
 */
#[Package('framework')]
abstract class AbstractBaseSalesChannelContextFactory
{
    /**
     * @param array<string, mixed> $options
     */
    abstract public function create(string $salesChannelId, array $options = []): BaseSalesChannelContext;
}
