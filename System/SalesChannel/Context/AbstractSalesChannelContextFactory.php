<?php declare(strict_types=1);

namespace HeyFrame\Core\System\SalesChannel\Context;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('framework')]
abstract class AbstractSalesChannelContextFactory
{
    abstract public function getDecorated(): AbstractSalesChannelContextFactory;

    /**
     * @param array<string, string|array<string,bool>|null> $options
     */
    abstract public function create(string $token, string $salesChannelId, array $options = []): SalesChannelContext;
}
