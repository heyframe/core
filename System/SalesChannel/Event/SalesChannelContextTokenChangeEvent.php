<?php declare(strict_types=1);

namespace HeyFrame\Core\System\SalesChannel\Event;

use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Contracts\EventDispatcher\Event;

#[Package('framework')]
class SalesChannelContextTokenChangeEvent extends Event implements HeyFrameSalesChannelEvent
{
    public function __construct(
        protected SalesChannelContext $salesChannelContext,
        protected string $previousToken,
        protected string $currentToken
    ) {
    }

    public function getSalesChannelContext(): SalesChannelContext
    {
        return $this->salesChannelContext;
    }

    public function getContext(): Context
    {
        return $this->salesChannelContext->getContext();
    }

    public function getPreviousToken(): string
    {
        return $this->previousToken;
    }

    public function getCurrentToken(): string
    {
        return $this->currentToken;
    }
}
