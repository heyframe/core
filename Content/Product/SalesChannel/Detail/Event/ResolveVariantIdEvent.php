<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Product\SalesChannel\Detail\Event;

use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Contracts\EventDispatcher\Event;

#[Package('checkout')]
class ResolveVariantIdEvent extends Event implements HeyFrameSalesChannelEvent
{
    public function __construct(
        private readonly string $productId,
        private ?string $resolvedVariantId,
        private readonly SalesChannelContext $salesChannelContext
    ) {
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function setResolvedVariantId(?string $resolvedVariantId): void
    {
        $this->resolvedVariantId = $resolvedVariantId;
    }

    public function getResolvedVariantId(): ?string
    {
        return $this->resolvedVariantId;
    }

    public function getContext(): Context
    {
        return $this->salesChannelContext->getContext();
    }

    public function getSalesChannelContext(): SalesChannelContext
    {
        return $this->salesChannelContext;
    }
}
